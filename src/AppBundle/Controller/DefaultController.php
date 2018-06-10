<?php

namespace AppBundle\Controller;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        /*$this->get('security.token_storage')->setToken(null);
        $this->get('session')->invalidate();*/
        //
        $client   = $this->get('eight_points_guzzle.client.api_city');
        $resp = $client->get('api/category/categories');
        $json = $resp->getBody()->getContents();
        //$json = str_replace("categoryID", "id", $json);
        /*echo $json;
        echo "<br>";*/
        //$str = '[{"id":1,"categoryTitle":"Pollution","categoryDescription":"Cumul de déchets des passants - ordures accumulées dans la rue - absence de conteneur poubelle…","categoryImage":"http://www.plan126.com/ios_icons/4.png"}]';
        //echo $resp->getBody()->getContents();
        $serializer = $this->get('jms_serializer');
        $context = new DeserializationContext();
        $context->setSerializeNull(true);
        $data = $serializer->deserialize($json, "array<AppBundle\Entity\Category>", 'json');
        //print_r($data);
        /*if(count($data)){
            foreach ($data as $category){
                //var_dump($category);
                echo '<br> <b>ID :: </b>'.$category->getCategoryId();
                echo '<br> <b>Title :: </b>'.$category->getCategoryTitle();
                echo '<br> <b>Desc :: </b>'.$category->getCategoryDescription();
                echo '<br>';
            }
        }*/
        //print_r($data);
        //return $response;
        return $this->render('@App/Default/index.html.twig', [
            'categories'=>$data,
        ]);
    }
}
