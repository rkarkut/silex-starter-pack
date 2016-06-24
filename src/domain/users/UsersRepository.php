<?php

namespace Ex\Domain\Users;

use Ex\Domain\ExRepository;
use Symfony\Component\Security\Core\User\User;

/**
 * Class UsersRepository
 * @package Ex\Domain\Users
 */
class UsersRepository extends ExRepository
{
    /**
     * @param string $email
     * @param string $password
     *
     * @return User
     * @throws \Exception
     */
    public function getUserByEmailAndPassword($email, $password)
    {
        $user = new User();

        $sql = '
        SELECT
            id,
            email,
            is_active,
            last_login_date,
            last_login_ip,
            created_at,
            updated_at
        FROM
            users
        WHERE
            email = ?
            AND password = ?';

        $result = $this->db->fetchAssoc($sql, [$email, $password]);

        if (empty($result)) {
            return $user;
        }

        $user->setId($result['id'])
            ->setEmail($result['email'])
            ->setIsActive($result['is_active'])
            ->setLastLoginDate($result['last_login_date'])
            ->setLastLoginIp($result['last_login_ip'])
            ->setCreatedAt($result['created_at'])
            ->setUpdatedAt($result['updated_at']);

        return $user;

    }

    public function getAllUsers()
    {

    }

    /**
     * @param string $email
     * @return mixed
     */
    public function getUserSaltByEmail($email)
    {
        $sql = "SELECT salt FROM users WHERE email = ? LIMIT 1";

        return $this->db->fetchColumn($sql, [$email]);
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function getUserPasswordByEmail($email)
    {
        $sql = "SELECT password FROM users WHERE email = ? LIMIT 1";

        return $this->db->fetchColumn($sql, [$email]);
    }
}