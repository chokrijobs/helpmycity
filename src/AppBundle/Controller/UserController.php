<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use AppBundle\Form\WebserviceUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/list", name="user_list")
     */
    public function listAction(Request $request)
    {
        $user = $this->getUser();
        $token = $user->getAccessToken();
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];
        $client = $this->get('eight_points_guzzle.client.api_city');
        $resp = $client->get('api/users/list', [
            'headers' => $headers,
        ]);
        $json = $resp->getBody()->getContents();
        $serializer = $this->get('jms_serializer');
        $data = $serializer->deserialize($json, "array<AppBundle\Security\User\WebserviceUser>", 'json');
        return $this->render('@App/User/list.html.twig', [
            'users' => $data,
        ]);
    }

    /**
     * @Route("/edit/{username}", name="user_edit", requirements={"username"="\w+"})
     */
    public function editAction(Request $request, $username)
    {
        $user = $this->getUser();
        $token = $user->getAccessToken();
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];
        $client = $this->get('eight_points_guzzle.client.api_city');
        $resp = $client->get('api/users/' . $username, [
            'headers' => $headers,
        ]);
        $json = $resp->getBody()->getContents();
        $serializer = $this->get('jms_serializer');
        $data = $serializer->deserialize($json, "AppBundle\Security\User\WebserviceUser", 'json');
        //echo $json;
        //print_r($data);
        ###
        $form = $this->createForm(WebserviceUser::class, $data);
        $form->add('submit', SubmitType::class, array(
            'label' => 'Update',
            'attr' => array('class' => 'btn btn-default pull-right'),
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $roles = [
                [
                    'id' => 3,
                    'role' => $data->getRoles(),
                ]
            ];
            $postData = [
                'id' => $data->getId(),
                'username' => $data->getUserName(),
                'name' => $data->getName(),
                'lastName' => $data->getLastName(),
                'email' => $data->getEmail(),
                'accessToken' => null,
                'roles' => $roles,
            ];
            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                //'Content-Type' => 'application/json'
            ];
            $resp = $client->post('api/users/update_user', [
                'headers' => $headers,
                //'form_params' => $postData
                'json' => $postData
            ]);
            ####
            $json = $resp->getBody()->getContents();
            $this->addFlash(
                'notice',
                'Modfication effectuée avec succès!'
            );
            return $this->redirectToRoute('user_edit', ['username' => $username]);
        }
        ###
        return $this->render('@App/User/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
