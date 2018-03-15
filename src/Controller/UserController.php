<?php
namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
class UserController extends Controller
{
    /**
     * @Route("/user", name="user_list")
     */
    public function userList() {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findAll();
        return $this->render('user/home.html.twig', array(
            'user'=>$user
        ));
    }
    /**
     * @Route("/user/{id}", name="user_detail", requirements={"id"="\d*"})
     */
    public function userDetail($id) {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneByIdFull($id);
        return $this->render('user/detail.html.twig', array(
            'user'=>$user
        ));
    }
    /**
     * @Route("/user/delete/{id}", name="user_delete")
     */
    public function userDelete(User $user) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('user_list');
    }
    /**
     *@Route("/user/add", name="user_add")
     */
    public function userAdd( Request $request ){
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        $msg = "";
        if( $form->isSubmitted() ){
            if($form->isValid()) {
                $newUser = $form->getData();
                $newUser->setIsActive(1);
                $newUser->setRole('ROLE_USER');
                $newUser->setPassword(password_hash($newUser->getPassword(), PASSWORD_BCRYPT));

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($newUser);
                $manager->flush();
                $msg = 'User added';
            } else {
                $msg = 'Thank you Mario, but the Princess is in another Castle!';
            }
        }
        return $this->render("user/form.html.twig",
            array(
                "form"=>$form->createView(),
                "message"=>$msg
            )
        );
    }
    /**
     *@Route("/user/edit/{id}", name="user_edit", requirements={"id"="\d*"})
     */
    public function userEdit( User $user, Request $request ){
        $form = $this->createForm(userType::class, $user);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        $msg = "";
        if( $form->isSubmitted() ){
            if($form->isValid()) {
                $newUser = $form->getData();
                $newUser->setIsActive(1);
                $newUser->setRole('ROLE_USER');
                $newUser->setPassword(password_hash($newUser->getPassword(), PASSWORD_BCRYPT));
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($newUser);
                $manager->flush();
                $msg = 'User modified';
            } else {
                $msg = 'Thank you Mario, but the Princess is in another Castle!';
            }
        }
        return $this->render("user/form.html.twig",
            array(
                "form"=>$form->createView(),
                "message"=>$msg
            )
        );
    }
    /**
     * @return string
     */
    private function generateUniqueFileName(){
        return md5(uniqid());
    }
}