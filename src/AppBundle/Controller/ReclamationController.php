<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/reclamation")
 */
class ReclamationController extends Controller
{
    /**
     * @Route("/list", name="reclamation_list")
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
        $resp = $client->get('api/reclamations/list',[
            'headers' => $headers,
        ]);
        $json = $resp->getBody()->getContents();
        /*echo $json;
        echo "<br>";*/
        $array = json_decode($json, true);
        //print_r($array);
        $_data = '{}';
        if(isset($array['content'])){
            $_data = json_encode($array['content']);
        }
        /*echo $_data;
        echo "<br>";*/
        $serializer = $this->get('jms_serializer');
        $data = $serializer->deserialize($_data, "array<AppBundle\Entity\Reclamation>", 'json');
        /*$data = $data['content'];
        print_r($data);*/
        //echo "<br>";
        return $this->render('@App/Reclamation/list.html.twig', [
            'reclamations' => $data,
        ]);
    }
    /**
     * @Route("/update", name="reclamation_update")
     */
    public function updateAction(Request $request)
    {
        $user = $this->getUser();
        $token = $user->getAccessToken();
        //echo "TOKEN: $token <br>";
        $status = $request->get('status');
        $id = $request->get('id');
        //api/reclamations/enable
        ###
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];
        $client = $this->get('eight_points_guzzle.client.api_city');
        $resp = $client->put('api/reclamations/enable',[
            'headers' => $headers,
            'query' => [
                'id' => $id,
                'isEnabled' => $status,
            ],
        ]);
        $json = $resp->getBody()->getContents();


        return new JsonResponse($json);
    }
}
