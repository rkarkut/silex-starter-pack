<?php
/**
 * Created by PhpStorm.
 * User: rkarkut
 * Date: 26/04/16
 * Time: 20:58
 */

namespace Ex\Domain\Users;


use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * UserProvider
 */
class UserProvider implements UserProviderInterface
{
    private $db;

    /**
     * UserProvider constructor.
     *
     * @param $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $username
     * @return User
     */
    public function loadUserByUsername($username)
    {
        $stmt = $this->db->executeQuery('SELECT * FROM users WHERE username = ?', [strtolower($username)]);

        $user = $stmt->fetch();

        if (!$user) {
            throw new UsernameNotFoundException(sprintf('Email "%s" does not exist.', $username));
        }

        return new User($user['username'], $user['password'], explode(',', $user['roles']), true, true, true, true);
    }

    /**
     * @param UserInterface $user
     * @return User
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }
}