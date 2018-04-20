<?php
session_start();

/**
 * Class SessionBA
 */
class SessionBA extends BaseBA
{
    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function Login($username, $password)
    {
        $da = new UserDA();

        $user = $da->GetUser($username);

      if (!empty($user) && password_verify($password, $user['Password']))
        {
            // If user is retrieved, and password matches.

            // Let's not store the password in a public session.
            unset($user['Password']);

            $_SESSION['user'] = $user;

            return true;
        }

        return false;
    }
}