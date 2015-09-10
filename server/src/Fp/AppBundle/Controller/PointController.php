<?php

namespace Fp\AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Rest controller for points.
 *
 * @author alex
 */
class PointController extends FOSRestController
{
    /**
     * Returms a list of points.
     *
     * @return View
     */
    public function getPointsAction()
    {
        $points = $this->get('doctrine_mongodb')
            ->getRepository('FpAppBundle:Point')
            ->findAll();

        return new View($points);
    }

    /**
     * @param string $id
     *
     * @return View
     */
    public function getPointAction($id)
    {
        $point = $this->get('doctrine_mongodb')
            ->getRepository('FpAppBundle:Point')
            ->find($id);

        if (!$point) {
            throw $this->createNotFoundException('No point found for id '.$id);
        }

        return new View($point);
    }

    /**
     * Creates a new post from the submitted data.
     *
     * @param Request $request the request object
     *
     * @return array|RouteRedirectView
     */
    public function postPointsAction(Request $request)
    {
        /* @var $serializer \JMS\Serializer\Serializer */
        $serializer = $this->get('jms_serializer');
        /* @var $validator \Symfony\Component\Validator\Validator */
        $validator = $this->get('validator');
        $point = $serializer->deserialize($request->getContent(), 'Fp\AppBundle\Document\Point', 'json');
        $errors = $validator->validate($point);

        if ($errors->count()) {
            return new View($errors, Codes::HTTP_BAD_REQUEST);
        }

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($point);
        $dm->flush();

        $locationUrl = $this->generateUrl(
            'get_point',
            ['id' => $point->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return new View(
            $point,
            Codes::HTTP_CREATED,
            ['Location' => $locationUrl]
        );
    }

    /**
     * Updates point.
     *
     * @param Request $request
     * @param string  $id
     *
     * @return array|RouteRedirectView
     */
    public function putPointsAction(Request $request, $id)
    {
        /* @var $serializer \JMS\Serializer\Serializer */
        $serializer = $this->get('jms_serializer');
        /* @var $validator \Symfony\Component\Validator\Validator */
        $validator = $this->get('validator');
        /* @var $point \Fp\AppBundle\Document\Point */
        $point = $serializer->deserialize($request->getContent(), 'Fp\AppBundle\Document\Point', 'json');
        $errors = $validator->validate($point);

        if ($errors->count()) {
            return new View($errors, Codes::HTTP_BAD_REQUEST);
        }

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($point);
        $dm->flush();

        return new View($point);
    }

    /**
     * Removes a point.
     *
     *
     * @param string $id the note id
     *
     * @return RouteRedirectView
     */
    public function deletePointsAction($id)
    {
        $point = $this->get('doctrine_mongodb')
            ->getRepository('FpAppBundle:Point')
            ->find($id);

        if (!$point) {
            throw $this->createNotFoundException('No point found for id '.$id);
        }

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->remove($point);
        $dm->flush();

        return $this->routeRedirectView('get_points', array(), Codes::HTTP_NO_CONTENT);
    }
}
