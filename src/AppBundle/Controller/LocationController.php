<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use AppBundle\Entity\Location;
use AppBundle\Entity\Photo;
use AppBundle\Entity\Review;
use AppBundle\Entity\Activity;
use AppBundle\Form\LocationType;
use AppBundle\Form\ReviewType;
use AppBundle\Form\PhotoType;
use AppBundle\Form\ActivityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LocationController extends Controller
{
    /**
     * @Route("/profile/add_location", name= "add_location"  )
     */
    public function addLocationAction(Request $request)
    {
        //build the form
        $location = new Location();

        $formAdd = $this->createForm( LocationType::class, $location);        
        
        //handle the submit
        $formAdd->handleRequest($request);
        if ($formAdd->isSubmitted() && $formAdd->isValid()) { 
            

            // get the user id
            $user = $this->getUser();

            // set the user id field
            $location->setUser($user);

            //get coordinates for the current location
            $point = $location->getName();
            $result = $this->container
                ->get('bazinga_geocoder.geocoder')
                ->using('google_maps')
                ->geocode($point);

            if (!$result) {
                throw $this->createNotFoundException('Location not found, try again !');
            }
            $address = $result->first();
            $localita = $address->getLocality();            
            $location->setLat($address->getLatitude());
            $location->setLng($address->getLongitude());            

            // save the user and form 
            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();
            
            $lastId=$location->getId();

            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Location added succefully!');

            $lastId = $location->getId();
            $url = $this->generateUrl('location', array('id'=>$lastId));
            return $this->redirect($url);

        }
        
        return $this->render('default/addlocation.html.twig',array('formAddLocation'=>$formAdd->createView()));
    }

    /**
    * @Route("/location/{id}", name="location", defaults = { "id" = 1 },options = { "expose" = true }, name = "location")
    *     
    */
    public function locationAction($id, Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository('AppBundle:Location')->findOneBy(['id'=>$id]);
        
        if (!$location) {
            throw $this->createNotFoundException('Location not found, try again !');
        }

        
        // get all the datas for the current location
        $reviews = $location->getReview();

        //pagination method
        /*$em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:Review')->getReviewByLocation($location)->getQuery();
        $paginator  = $this->get('knp_paginator');
        $pageReview = $paginator->paginate(
            $query, /* query NOT result */
            //$request->query->getInt('page', 2)/*page number*/,
            //$request->query->getInt('limit', 2)/*limit per page*/
        //);


        $photos = $location->getPhoto();
        $em = $this->getDoctrine()->getManager();
        $sights = $em->getRepository('AppBundle:Activity')->findBySS($location);
        $sports = $em->getRepository('AppBundle:Activity')->findByOS($location);
        $others = $em->getRepository('AppBundle:Activity')->findByOT($location);
        // get the rating average
        $rating[] = null;
        if ($reviews == null){
            $avRating = 0;            
        }
        else{            
            foreach ($reviews as $review){
                $rating[] = $review->getRating();
            }
            $avRating = ceil(array_sum($rating)/count($rating));
        }

        //add activities
        $activity = new Activity();
        $formAddActivity = $this->createForm(ActivityType::class, $activity);
        $formAddActivity->handleRequest($request);
        if ($formAddActivity->isSubmitted() && $formAddActivity->isValid()) {
            $user = $this->getUser();
            $activity->setUser($user);
            $activity->setLocation($location);
            $activity->setDateIns('now');
            $em = $this->getDoctrine()->getManager();
            $em->persist($activity);
            $em->flush();
            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Activity added succefully!');
            $url = $this->generateUrl('location', array('id'=>$location->getId()));
            return $this->redirect($url);

        }

        //add review 
        $review = new Review();
        $formAddReview = $this->createForm(ReviewType::class, $review);
        $formAddReview->handleRequest($request);
        if ($formAddReview->isSubmitted() && $formAddReview->isValid()) {

            // get the user id
            $user = $this->getUser();           
            // set the user id field
            $review->setUser($user);
            //set the location id
            $review->setLocation($location);
            $review->setDateIns();
            // save the user and form 
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();
            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Review added succefully!');
            $lastId = $location->getId();
            $url = $this->generateUrl('location', array('id'=>$lastId));
            return $this->redirect($url);
        }

        //add pictures for the current location shown
        $photo = new Photo();
        $formPhoto = $this->createForm(PhotoType::class, $photo);     
        
        //handle the submit
        $formPhoto->handleRequest($request);
        if ($formPhoto->isSubmitted() && $formPhoto->isValid()) {            

            // get the user id
            $user = $this->getUser();

            // set the user id field
            $photo->setUser($user);
            $photo->setLocation($location);
            $photo->setDatePost('now');

            // save the user and form 
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();           

            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Photo added succefully!');

            $lastId = $location->getId();
            $url = $this->generateUrl('location', array('id'=>$lastId));
            return $this->redirect($url);
        }

        return $this->render('default/location.html.twig', array('location'=>$location, 'reviews'=>$reviews,'rating'=>$avRating, 'photos'=>$photos, 'formAddReview'=>$formAddReview->createView(), 'formAddPhoto'=>$formPhoto->createView(), 'formAddActivity'=>$formAddActivity->createView(), 'sports'=>$sports, 'sights'=>$sights,'others'=>$others));
    }

    /**
     * @Route("/location/review/delete/{id}", name= "reviewDelete"  ) 
     */
    public function reviewDeleteAction($id)
    {
         //render the contact request 
        $em = $this->getDoctrine()->getManager();
        $review = $em->getRepository('AppBundle:Review')->find($id);
        $location = $review->getLocation();
        $idLocation = $location->getId();
        $em->remove($review);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
                                            'success',
                                            'Comment deleted');

        return $this->redirectToRoute('location', ['id'=> $idLocation]);
    }

}