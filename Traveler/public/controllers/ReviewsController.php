<?php

namespace controllers;

use core\Controller;
use core\Core;
use models\Review;
use models\User;

class ReviewsController extends Controller
{
    public function indexAction()
    {
        return $this->pageAction([1]);
    }

    public function adminAction(array $params)
    {
        return $this->pageAction(empty($params) ? [1] : $params, true);
    }

    public function pageAction(array $params, bool $admin = false)
    {
        $page = intval($params[0]);
        if ($page < 1)
            $this->error(404);

        $reviews = Review::getReviewsList($page - 1);

        if (empty($reviews))
            $this->error(404);


        $isLoggedIn = User::isLogUser();
        $isModer = User::isCurrentUserModerator();

        for ($i = 0; $i < count($reviews); $i++) {
            $reviews[$i]['author'] = User::getUserById($reviews[$i]['author_id']);
            $reviews[$i]['photo_list'] = json_decode($reviews[$i]['photo_json']);
            $reviews[$i]['date'] = date("d/m/Y", strtotime($reviews[$i]['date']));
        }
        return $this->render(path: "views/reviews/index.php", params: [
            'reviews' => $reviews,
            'isLoggedIn' => $isLoggedIn,
            'isModer' => $admin && $isModer,
            'user' => User::getCurrentUser(),
            'page' => $page,
            'pagesCount' => Review::getPagesCount(),
            'header_page' => 'reviews'
        ]);
    }

    public function addAction()
    {
        if (Core::getInstance()->requestMethod == "POST" && User::isLogUser()) {
            $user = User::getCurrentUser();
            $author_id = $user['id'];
            $text = $_POST['text'];

            if (array_key_exists('photo_list', $_FILES))
                $photo_list = $_FILES['photo_list'];
            else
                $photo_list = [];

            Review::addReview($author_id, $text, $photo_list);
            $this->message("Відгук додано", "positive");
        }
        die;
        //header('Location: /reviews');
    }

    public function deleteAction()
    {
        if (Core::getInstance()->requestMethod == "POST" && User::isLogUser()) {
            $review_id = $_POST['review_id'];
            $user = User::getCurrentUser();

            if (User::isCurrentUserModerator() || Review::isUserReview($review_id, $user['id']))
            {
                Review::deleteReview($review_id);
                $this->message("Відгук видалено", "neutral");
            }
        }
        die;
    }
}