<?php

namespace App\Controller;

use App\Form\SystemType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\System;

class SystemController extends Controller
{

    /**
     * @Route("/system/{id}", name="system_show", requirements={"id"="\d+"})
     */
    public function showAction($id)
    {
        $system = $this->getDoctrine()
            ->getRepository(System::class)
            ->find($id);

        if (!$system) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
//      return new Response('Check out this great product: '.$system->getName() .$system->getDescription());
        return $this->render('systemshow.html.twig', ['system' => $system]);
//        return $this->redirectToRoute('system_show', ['id' => $system->getId();
    }


    /**
     * @Route("/system/add", name="system_add")
     */

    public function systemAdd(Request $request)
    {
        $system = new System();
        $form = $this->createForm(SystemType::class, $system);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            $system = $form->getData();

            //Images
            $file = $newSystem->getImage();
            $definitiveFileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_images_directory').'/system',$definitiveFileName);
            $newSystem->setImage($definitiveFileName);

            $this->addFlash(
                'notice',
                'System successfully added!'
            );
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($system);
            $em->flush();

            return $this->redirectToRoute('system_add');
        }

        return $this->render('systemadd.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/system/edit/{id}", name="system_edit", requirements={"id"="\d*"})
     */
    public function systemEdit(System $system, Request $request)
    {
        $form = $this->createForm(SystemType::class, $system);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $newSystem = $form->getData();

                //Images
                $file = $newSystem->getImage();
                $definitiveFileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_images_directory').'/system',$definitiveFileName);
                $newSystem->setImage($definitiveFileName);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($newSystem);
                $manager->flush();

                $this->addFlash(
                    'notice',
                    'System successfully changed!'
                );
            }
        }
        return $this->render("systemadd.html.twig",
            array("form" => $form->createView(),

            )
        );
    }


    /**
     * @Route("/system/delete/{id}", name="system_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $system = $em->getRepository(System::class)->find($id);

        if (!$system) {
            throw $this->createNotFoundException(
                'No System found for id ' . $id
            );
        }
        $em->remove($system);
        $em->flush();
//        return new Response('Your System was succesfully deleted: '.$system->getName());
        $this->addFlash(
            'notice',
            'System successfully deleted!'
        );
        // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
        return $this->redirectToRoute('system_list');
    }

     /**
     * @return string
     */
    private function generateUniqueFileName(){
        return md5(uniqid());
    }


    /**
     * @Route("/system", name="system_list")
     */
    public function listAsc()
    {
        $system = $this->getDoctrine()
            ->getRepository(System::class)
            ->findAllAndOrderAsc();

        return $this->render(
            'system.html.twig', array('systemList' => $system));
//            return new Response('Check out all the great System: '.$system->getName());
    }
}
