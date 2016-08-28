<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use AppBundle\Entity\Location;
use AppBundle\Entity\Photo;
use AppBundle\Form\LocationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;

class LocationController extends Controller
{
    /**
     * @Route("/add_location", name= "add_location"  )
     */
    public function addLocationAction(Request $request)
    {
        //build the form
        $location = new Location();

        $formAdd = $this->createForm( LocationType::class, $location );
        
        
        //handle the submit
        $formAdd->handleRequest($request);
        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            
            // get the user id
            $user = $this->getUser();

            // set the user id field
            $location->setUser($user);

            // save the user and form 
            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();

            /*//get the location id
            $locationid = $location->getId();
            // set the location id field
            $photo->setIdLocation($locationid);
            // persist in the database
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();*/
            $this->get('session')->getFlashBag()->add(
                                            'noticeLocation',
                                            'Location added succefully!');

        }
        
        return $this->render('default/addlocation.html.twig',array('formAddLocation'=>$formAdd->createView()));
    }
    public function addPhotoAction(Request $request)
    {

    }


}