<?php

namespace App\Controller;

use App\Form\RomType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Rom;

class RomController extends Controller
{

    /**
     * @Route("/rom/{id}", name="rom_show", requirements={"id"="\d+"})
     */
    public function showAction($id)
    {
        $rom = $this->getDoctrine()
            ->getRepository(Rom::class)
            ->find($id);

        if (!$rom) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
//      return new Response('Check out this great product: '.$rom->getName() .$rom->getDescription());
        return $this->render('Roms/romshow.html.twig', ['rom' => $rom]);
//        return $this->redirectToRoute('rom_show', ['id' => $rom->getId();
    }


    /**
     * @Route("/rom/add", name="rom_add")
     */

    public function romAdd(Request $request)
    {
        $rom = new Rom();
        $form = $this->createForm(RomType::class, $rom);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            $newRom = $form->getData();
            
            //Images
            $file = $newRom->getImage();
            $definitiveFileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_images_directory').'/rom',$definitiveFileName);
            $newRom->setImage($definitiveFileName);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newRom);
            $manager->flush();


            $this->addFlash(
                'notice',
                'Rom successfully added!'
            );
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($rom);
            $em->flush();

            return $this->redirectToRoute('rom_add');
        }

        return $this->render('Roms/romadd.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/rom/edit/{id}", name="rom_edit", requirements={"id"="\d*"})
     */
    public function romEdit(Rom $rom, Request $request)
    {
        $form = $this->createForm(RomType::class, $rom);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                

                $newRom = $form->getData();

                //Images
                $file = $newRom->getImage();
                $definitiveFileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_images_directory').'/rom',$definitiveFileName);
                $newRom->setImage($definitiveFileName);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($newRom);
                $manager->flush();

                $this->addFlash(
                    'notice',
                    'Rom successfully changed!'
                );
            }
        }
        return $this->render("Roms/romadd.html.twig",
            array("form" => $form->createView(),

            )
        );
    }

    /**
     * @return string
     */
    private function generateUniqueFileName(){
        return md5(uniqid());
    }

    /**
     * @Route("/rom/delete/{id}", name="rom_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $rom = $em->getRepository(Rom::class)->find($id);

        if (!$rom) {
            throw $this->createNotFoundException(
                'No Rom found for id ' . $id
            );
        }
        $em->remove($rom);
        $em->flush();
//        return new Response('Your Rom was succesfully deleted: '.$rom->getName());
        $this->addFlash(
            'notice',
            'Rom successfully deleted!'
        );
        // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
        return $this->redirectToRoute('rom_list');
    }


    /**
     * @Route("/rom", name="rom_list")
     */
    public function listAsc()
    {
        $rom = $this->getDoctrine()
            ->getRepository(Rom::class)
            ->findAllAndOrderAsc();

        return $this->render(
            'Roms/roms.html.twig', array('romList' => $rom));
//            return new Response('Check out all the great Roms: '.$rom->getName());
    }
}
