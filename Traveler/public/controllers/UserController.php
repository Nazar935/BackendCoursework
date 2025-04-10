<?php

namespace controllers;

use core\Controller;
use core\Core;
use models\Booking;
use models\Saved;
use models\User;

class UserController extends Controller
{
    public function indexAction(): string
    {
        if (User::isLogUser()) {
            $user = User::getCurrentUser();
            return $this->render(params: [
                'isCurrentUser' => true,
                'user' => $user,
                'header_page' => 'user',
                'isUserModerator' => User::isUserModerator($user['username']),
                'isCurrentUserModerator' => User::isCurrentUserModerator(),
                'savedTours' => Saved::getSavedToursList($user['id']),
                'bookingArray' => Booking::getBookingArrayForUser($user['id'])
            ]);
        }
        header('Location: /home/');
        die;
    }

    public function json_searchAction()
    {
        if (Core::getInstance()->requestMethod != "POST")
            $this->error(404);

        $searchText = $_POST['search_text'];
        $userArray = User::getUserList($searchText);

        header('Content-type: application/json');
        echo json_encode($userArray);
        die();
    }

    public function blockAction()
    {
        if (User::isCurrentUserModerator()) {
            $user_id = intval($_POST['user_id']);
            if (User::getUserById($user_id)) {
                $user = User::blockUser($user_id);

                if ($user['blocked'])
                    $this->message("Користувач \"" . $user['username'] ."\" заблокований", "neutral");
                else
                    $this->message("Користувач \"" . $user['username'] ."\" розблокований", "positive");

                header('Content-type: application/json');
                echo json_encode($user);
            }
        }
        die;
    }
    public function registerAction(): string
    {
        if (Core::getInstance()->requestMethod == 'POST')
        {
            $error = "";
            if (!preg_match('/^[a-zA-Z0-9._-]+$/', $_POST['username']))
                $error = 'Логін може містити тільки a-Z, 0-9, "_", "-" символи!';
            if ($_POST['password'] != $_POST['password2'])
                $error = 'Паролі повинні співпадати';
            if (!User::isUsernameUsed($_POST['username']))
                $error = 'Логін уже зайнятий!';
            if ($error)
                return $this->render("views/user/register/index.php", params: [
                    'error' => $error,
                    'model' => $_POST
                ]);
            else {
                User::newUser($_POST['username'], $_POST['password']);
                $user = User::getUser($_POST['username'], $_POST['password']);
                User::loginUser($user);
                $this->message("Успішна реєстрація аккаунту", "positive");
                header('Location: /home/');
                die;
            }
        } else
            return $this->render("views/user/register/index.php", params: [
                'header_page' => 'user'
            ]);
    }
    public function loginAction(): string
    {
        if (Core::getInstance()->requestMethod == 'POST')
        {
            $user = User::getUser($_POST['username'], $_POST['password']);
            if (empty($user))
                return $this->render("views/user/login/index.php", params: [
                    'error' => 'Неправильний логін або пароль',
                    'model' => $_POST
                ]);
            else
            {
                if ($user['blocked']) {
                    $this->message("Ваш аккаунт заблоковано", "negative");
                    $this->redirect("/user/login");
                    die;
                }
                User::loginUser($user);
                $this->message("Успішний вхід в аккаунт", "positive");
                header('Location: /home');
                die;
            }
        }
        return $this->render("views/user/login/index.php", params: [
            'header_page' => 'user'
        ]);
    }

    public function logoutAction(): void
    {
        if (User::isLogUser())
            User::logoutUser();
        header('Location: /home');
    }

    public function viewAction($params)
    {
        if (!empty($params))
        {
            $user = User::getUserById(User::getUserId($params[0]));
            if (empty($user))
            {
                return $this->error(404);
            }
            $isCurrentUser = User::getCurrentUser()['id'] == $user['id'];
            $isCurrentUserModerator = User::isCurrentUserModerator() && !(User::isUserModerator($user['username']));
            return $this->render(path:'views/user/index.php', params: [
                'isCurrentUser' => $isCurrentUser,
                'isUserModerator' => User::isUserModerator($user['username']),
                'isCurrentUserModerator' => User::isCurrentUserModerator(),
                'user' => $user,
                'header_page' => 'user',
                'savedTours' => Saved::getSavedToursList($user['id']),
                'bookingArray' => Booking::getBookingArrayForUser($user['id'])
            ]);
        }

        header('Location: /home/');
        die;
    }
}