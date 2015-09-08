<?php

namespace Fp\AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Fp\AppBundle\Form\PointType;
use Fp\AppBundle\Document\Point;

/**
 * Rest controller for points
 *
 * @author alex
 */
class PointController extends FOSRestController
{
    /**
     *
     * @return array
     */
    public function getPointsAction()
    {
        $points = $this->get('doctrine_mongodb')
            ->getRepository('FpAppBundle:Point')
            ->findAll();

        $view = $this->view($points)
            ->setTemplate('FpAppBundle:Point:points.html.twig');

        return $this->handleView($view);
    }

    /**
     * @Annotations\View(templateVar="point")
     *
     * @param string $id
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
     * Display create point form
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newPointAction()
    {
        $form = $this->createForm(new PointType);

        return $this->render('FpAppBundle:Point:newPoint.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Creates a new post from the submitted data.
     *
     *
     * @Annotations\View(
     *   template = "FpAppBundle:Point:newPoint.html.twig",
     *   statusCode = Codes::HTTP_BAD_REQUEST
     * )
     *
     * @param Request $request the request object
     *
     * @return array|RouteRedirectView
     */
    public function postPointsAction(Request $request)
    {
        $point = new Point;
        $form = $this->createForm(new PointType(), $point);

        $form->submit($request);
        if ($form->isValid()) {
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($point);
            $dm->flush();

            return new View($point, Codes::HTTP_CREATED);
            /**
             * causes error when using Restangular
             */
//            return $this->routeRedirectView('get_point', ['id' => $point->getId()]);
        }

        return ['form' => $form];
    }

    /**
     * Updates point.
     *
     * @param Request $request
     * @param string $id
     *
     * @return array|RouteRedirectView
     */
    public function putPointsAction(Request $request, $id)
    {
        $point = $this->get('doctrine_mongodb')
            ->getRepository('FpAppBundle:Point')
            ->find($id);

        if (!$point) {
            throw $this->createNotFoundException('No point found for id '.$id);
        }

        $form = $this->createForm(new PointType(), $point);

        $form->submit($request);
        if ($form->isValid()) {
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($point);
            $dm->flush();

            return new View($point);
//            return $this->routeRedirectView('get_point', ['id' => $point->getId()], Codes::HTTP_NO_CONTENT);
        }

        return ['form' => $form];
    }

    /**
     * Removes a point.
     *
     *
     * @param Request $request the request object
     * @param int     $id      the note id
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
