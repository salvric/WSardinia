<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use AppBundle\Entity\Location;
use AppBundle\Entity\Photo;
use AppBundle\Entity\Review;
use AppBundle\Form\LocationType;
use AppBundle\Form\ReviewType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

        $formAdd = $this->createForm( LocationType::class, $location );
        
        
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
    * @Route("/location/{id}", name="location")
    */
    public function locationAction($id, Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository('AppBundle:Location')->findOneBy(['id'=>$id]);
        
        if (!$location) {
            throw $this->createNotFoundException('Location not found, try again !');
        }
        // get all the review for the current location
        $reviews = $location->getReview();
        
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
            $lastId = $location->getId();
            $url = $this->generateUrl('location', array('id'=>$lastId));
            return $this->redirect($url);
        }
        return $this->render('default/location.html.twig', array('location'=>$location, 'reviews'=>$reviews,'rating'=>$avRating, 'formAddReview'=>$formAddReview->createView()));
    }


    /**
    * @Route("/", name="homepage")
    */
    public function showLatestLocation()
    {
        $em = $this->getDoctrine()->getManager();
        $locations = $em->getRepository('AppBundle:Location')->findLatest(4);
        return $this->render('default/index.html.twig', array('lastLocations'=>$locations));
    }

    /**
     * @Route("/location/{id}/review")
     * @Method("GET")
     */
    

}