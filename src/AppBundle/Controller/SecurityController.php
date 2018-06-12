<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
####
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

####
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $user = $this->getUser();
        if ($user instanceof UserInterface) {
            return $this->redirectToRoute('homepage');
        }
        if ($request->isMethod('POST')) {
            $email = $request->get('_email');
            $password = $request->get('_password');
            $client = $this->get('eight_points_guzzle.client.api_city');
            //
            try {
                $resp = $client->post('api/auth/signin', [
                    'form_params' => [
                        'email' => $email,
                        'password' => $password,
                    ]
                ]);
                if ($resp->getStatusCode() == 200) {
                    $json = $resp->getBody()->getContents();
                    $serializer = $this->get('jms_serializer');
                    $user = $serializer->deserialize($json, "AppBundle\Security\User\WebserviceUser", 'json');
                    $token = new UsernamePasswordToken($user, null, 'main', ['ROLE_ADMIN']);
                    $this->get('security.token_storage')->setToken($token);
                    $this->get('session')->set('_security_main', serialize($token));
                    return $this->redirectToRoute('homepage');
                } else {
                    return $this->redirectToRoute('login');
                }
            } catch (\Exception $e){
                $this->addFlash(
                    'notice',
                    'Erreur de connexion !'
                );
                return $this->redirectToRoute('login');
            }

        }
        return $this->render('@App/Security/login.html.twig', array(/*'last_username' => $lastUsername,
            'error'         => $error,*/
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logOutAction()
    {
        $this->get('security.token_storage')->setToken(null);
        $this->get('session')->invalidate();
        return $this->redirectToRoute('homepage');
    }
}
