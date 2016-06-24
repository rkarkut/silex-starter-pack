<?php

namespace Ex\Domain\Users;


use Ex\Core\ExApplication;

/**
 * Class UsersService
 * @package Ex\Domain\Users
 */
class UsersService
{
    private $exSalt = '5!qk4$sk0)10!$;';

    /**
     * @var UsersRepository
     */
    private $repository;

    private $session;

    /**
     * @param ExApplication $app
     */
    public function __construct(ExApplication $app)
    {
        $this->session = $app['session'];
        $this->repository = new UsersRepository($app['db']);
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return bool
     * @throws \Exception
     */
    public function validateUserEmailAndPassword($email, $password)
    {
        if (empty($email) || empty($password) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Incorrect parameters');
        }

        $salt = $this->getUserSaltByEmail($email);
        $encryptedPassword = $this->generateEncodedPassword($password, $salt);

        $encryptedPasswordInDb = $this->repository->getUserPasswordByEmail($email);

        if (empty($encryptedPassword)) {
            return false;
        }

        if ($encryptedPassword === $encryptedPasswordInDb) {

            $this->session->set('user', [
                'email'         => $email,
                'security_code' => $salt
            ]);

            return true;
        }

        return false;
    }

    /**
     * @param string $password
     * @param string $salt
     *
     * @return string
     */
    public function generateEncodedPassword($password, $salt)
    {
        for ($i = 0; $i < 200; $i++) {
            $password = sha1($password . '|' . $salt . '|' . $this->exSalt);
        }

        return $password;
    }

    /**
     * @return string
     */
    public function generateSalt()
    {
        return substr( sha1(rand()), 0, 20);
    }

    /**
     * @param string $email
     * @return mixed
     * @throws \Exception
     */
    private function getUserSaltByEmail($email)
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Incorrect email');
        }

        return $this->repository->getUserSaltByEmail($email);
    }
}