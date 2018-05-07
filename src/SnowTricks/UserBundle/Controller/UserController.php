<?php

namespace SnowTricks\UserBundle\Controller;

use SnowTricks\UserBundle\Form\DashboardType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function dashboardAction(Request $request)
    {
        $user = $this->getUser();

        $savePictureUser = $user->getPicture();

        $form = $this->createForm(DashboardType::class, $user);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {


                if($user->getPicture() != null && $savePictureUser != null)
                {
                    $file = $this->container->getParameter('pictures_directory').'/'.$savePictureUser;

                    unlink($file);
                }
                elseif($savePictureUser != null)
                {
                    $user->setPicture($savePictureUser);
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Your account has been updated !'
                );

                return $this->redirectToRoute('snow_tricks_user_dashboard');
            }
        }

        return $this->render('@SnowTricksUser/dashboard.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteUserPictureAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('SnowTricksUserBundle:User')->find($id);

        unlink($this->container->getParameter('pictures_directory').'/'.$user->getPicture());
        $user->setPicture(null);

        $em->persist($user);
        $em->flush();

        $this->addFlash(
            'notice',
            'Your avatar has been deleted !'
        );

        return $this->redirectToRoute('snow_tricks_user_dashboard');
    }
}
