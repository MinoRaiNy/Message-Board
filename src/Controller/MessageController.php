<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Message;
use App\Entity\Reply;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     */
    public function index()
    {
        $message = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findAll();

        return $this->render('message/index.html.twig', [
            'controller_name' => "MinoRaiNy's Message Board",
	          'message' => $message
        ]);
    }

    /**
     * @Route("/message/add", name="message_add")
     */
    public function add(Request $request)
    {
        $enter = $request->get('enter');
        $message = new Message();
        $message->setName($enter);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($message);
        $entityManager->flush();

        return $this->redirectToRoute('message');
    }

    /**
     * @Route("/message/reply", name="message_reply")
     */
    public function reply(Request $request)
    {
        $id = $request->get('postid');
        return $this->render('message/reply.html.twig', [
            'show_message' => 'Enter Your Reply !',
            'reply_id' => $id
        ]);

    }

    /**
     * @Route("/message/goreply", name="message_goreply")
     */
    public function goreply(Request $request)
    {
        $enter = $request->get('enter');
        $id = $request->get('postid');
        $message = $this->getDoctrine()
            ->getRepository(Message::class)
            ->find($id);

        $reply = new Reply();
        $reply->setName($enter);
        $reply->setMessage($message);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($message);
        $entityManager->persist($reply);
        $entityManager->flush();

        return $this->redirectToRoute('message');
    }

    /**
     * @Route("/message/del", name="message_del")
     */
    public function del(Request $request)
    {
        $id = $request->get('postid');
        $entityManager = $this->getDoctrine()->getManager();
        $message = $entityManager->getRepository(Message::class)
            ->find($id);
        $replys = $message->getReplys();

        foreach ($replys as $reply)
        {
            $rId = $reply->getId();
            $delId = $entityManager->getRepository(Reply::class)
                ->find($rId);
            $entityManager->remove($delId);
            $entityManager->flush();
        }
        $entityManager->remove($message);
        $entityManager->flush();

        return $this->redirectToRoute('message');
    }

    /**
     * @Route("/message/delreply", name="message_delreply")
     */
    public function delreply(Request $request)
    {
        $id = $request->get('postid');
        $entityManager = $this->getDoctrine()->getManager();
        $reply = $entityManager->getRepository(Reply::class)
            ->find($id);
        $entityManager->remove($reply);
        $entityManager->flush();

        return $this->redirectToRoute('message');
    }

    /**
     * @Route("/message/fix", name="message_fix")
     */
    public function fix(Request $request)
    {
        $id = $request->get('postid');
        return $this->render('message/fix.html.twig', [
            'show_message' => 'Enter Your Fix !',
            'fix_id' => $id
        ]);
    }

    /**
     * @Route("/message/gofix", name="message_gofix")
     */
    public function gofix(Request $request)
    {
        $enter = $request->get('enter');
        $id = $request->get('postid');
        $message = $this->getDoctrine()
            ->getRepository(Message::class)
            ->find($id)->setName($enter);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('message');
    }
}
