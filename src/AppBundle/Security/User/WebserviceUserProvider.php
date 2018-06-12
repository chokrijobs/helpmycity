<?php
/**
 * Created by PhpStorm.
 * User: chokri
 * Date: 05/06/18
 * Time: 23:48
 */

namespace AppBundle\Security\User;

use AppBundle\Security\User\WebserviceUser;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use GuzzleHttp\Client;
use JMS\Serializer\Serializer;
class WebserviceUserProvider implements UserProviderInterface
{
    /**
     * @var Client
     */
    private $client;
    private $serializer;
    private $session;

    public function __construct(Client $client, Serializer $serializer, Session $session)
    {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->session = $session;
    }

    public function loadUserByUsername($username)
    {
        //echo "<br>AAAAAAAAAAAAA<br>";
        // make a call to your webservice here
        //$userData = '...';
        $password = 'test';
        /*$resp = $this->client->post('api/auth/signin', [
            'form_params'=>[
                'email'=>'test@gmail.com',
                'password'=>'test',
            ],
        ]);*/
        $resp = $this->client->get('/api/users/'.$username, []);

        $json = $resp->getBody()->getContents();
        //echo $json;
        $serializer = $this->serializer;
        $userData = $serializer->deserialize($json, "AppBundle\Security\User\WebserviceUser", 'json');
        //var_dump($userData);
        // pretend it returns an array on success, false if there is no user

        if ($userData) {
            $password = $password;
            $salt = $password;
            $roles = ['ROLE_ADMIN'];
            $accessToken = $this->session->get('accessToken');

            return new WebserviceUser($username, $password, $salt, $roles, $accessToken);
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return WebserviceUser::class === $class;
    }
}