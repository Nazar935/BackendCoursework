<?php

namespace models;

use core\Core;

class User
{
    public static string $table_name = "user";
    public static array $pfp_colors = ["blue", "orange", "green", "pink"];

    public static function getUserList($searchText = null): array
    {
        $userArray = Core::getInstance()->db->select(self::$table_name, ["*"], order: "id desc", search: [
            'username' => $searchText
        ]) ?? [];
        foreach ($userArray as $i => $user)
            $userArray[$i] = self::processProfilePicture($user);
        return $userArray;
    }

    public static function blockUser($user_id): array
    {
        $user = Core::getInstance()->db->select(self::$table_name, ["*"], ["id" => $user_id])[0];
        $blocked = 1;
        if (intval($user['blocked']))
            $blocked = 0;
        Core::getInstance()->db->update(self::$table_name, [
            'blocked' => $blocked
        ], 'id', $user_id);

        return self::processProfilePicture(Core::getInstance()->db->select(self::$table_name, ["*"], ["id" => $user_id])[0]);
    }

    public static function newUser(string $username, string $password): void
    {
        Core::getInstance()->db->insert(self::$table_name, [
            'username' => $username,
            'password' => md5($password),
            'color' => self::$pfp_colors[random_int(0, 3)]
        ]);
    }

    public static function loginUser(array $user): void
    {
        $_SESSION['user'] = $user;
    }

    public static function logoutUser(): void
    {
        unset($_SESSION['user']);
    }

    public static function getUser(string $username, string $password): array|null
    {
        $query_result = Core::getInstance()->db->select('user', ['*'], [
            'username' => $username,
            'password' => md5($password)
        ]);

        return self::processProfilePicture($query_result[0] ?? null);
    }

    public static function getUserById(int|null $id): array|null
    {
        $query_result = Core::getInstance()->db->select('user', ['*'], [
            'id' => $id
        ]);
        return self::processProfilePicture($query_result[0] ?? null);
    }

    public static function isLogUser(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function getCurrentUser(): array|null
    {
        if (!self::isLogUser())
            return null;
        $res = Core::getInstance()->db->select(self::$table_name, ['*'], [
            'id' => $_SESSION['user']['id']
        ]);
        if ($res)
        {
            $_SESSION['user'] = self::processProfilePicture($res[0]);
            return $_SESSION['user'];
        }
        else
            return null;
    }

    public static function isUsernameUsed(string $username): bool
    {
        return empty(Core::getInstance()->db->select('user', ['username'], ['username' => $username]));
    }

    public static function isUserModerator(string $username): bool
    {
        if (!User::isLogUser())
            return false;
        $user = Core::getInstance()->db->select('user', ['*'], ['username' => $username])[0];
        if ($user['id'] == '1')
            return true;
        return false;
    }

    public static function isCurrentUserModerator(): bool
    {
        $user = User::getCurrentUser();
        $isModer = false;
        if ($user && User::isUserModerator($user['username']))
            $isModer = true;
        return $isModer;
    }

    public static function getUserId($username): string | null
    {
        $user = Core::getInstance()->db->select('user', ['*'], [
            'username' => $username
        ]);
        if (empty($user))
            return null;
        return $user[0]['id'];
    }

    public static function processProfilePicture(array|null $user): array | null
    {
        if (!$user)
            return $user;

        $colorsArray = [
            'blue' => [
                'background' => 'linear-gradient(#5ACAE3, #359AD3)',
                'font_color' => '#fff'
            ],
            'orange' => [
                'background' => 'linear-gradient(#FEB859, #F68337)',
                'font_color' => '#fff'
            ],
            'green' => [
                'background' => 'linear-gradient(#97CE63, #45B542)',
                'font_color' => '#fff'
            ],
            'pink' => [
                'background' => 'linear-gradient(#FE89AB, #D35372)',
                'font_color' => '#fff'
            ],
            'grey' => [
                'background' => 'linear-gradient(#e8e8e8, #cfcfcf)',
                'font_color' => '#fff'
            ]
        ];

        $user['picture'] = $colorsArray[$user['color']];
        if ($user['blocked'])
            $user['picture'] = $colorsArray['grey'];
        $user['picture']['letter'] = substr($user['username'], 0, 1);
        $user['is_admin'] = User::isUserModerator($user['username']);


        return $user;
    }
}