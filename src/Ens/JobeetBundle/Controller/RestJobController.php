<?php

namespace Ens\JobeetBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController as Controller;
use Doctrine\ORM\entityManager;
use Ens\JobeetBundle\Entity\Job;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class RestJobController extends Controller {

    /**
     * Create a product
     * @ApiDoc(
     * resource=true,
     * section="Rest CRUD Job",
     * description="Create entity",
     * statusCodes= {
     * 200 = "returned when successful job is created",
     * 404 = "returned when job is not created",
     * 400 = "returned when the form has errors"
     * },
     * input="Ens\JobeetBundle\Entity\Job",
     * output="Ens\JobeetBundle\Entity\Job",
     * )
     * 
     */
    public function getJobAction($id) {
        $entityManager = $this->getDoctrine()->getManager();

        $job = $entityManager->getRepository('EnsJobeetBundle:Job')->findOneById($id);

        if ($job) {
            $view = $this->view($job, 200);
        } else {
            $view = $this->view(" ", 404);
        }

        return $this->handleView($view);
    }

    public function getJobsAction() {
        $entityManager = $this->getDoctrine()->getManager();

        $job = $entityManager->getRepository('EnsJobeetBundle:Job')->findAll();

        if ($job) {
            $view = $this->view($job, 200);
        } else {
            $view = $this->view(" ", 404);
        }

        return $this->handleView($view);
    }

    public function postJobAction() {
        $job = new Job();

        $json = json_decode($this->getRequest()->getContent(), true);

        $this->extract($job, $json);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($job);
        $entityManager->flush();

        $view = $this->view($job, 200);

        return $this->handleView($view);
    }

    public function extract(Job $job, $json) {
        if ($json) {
            // Complet with all argument of my entity
            if (array_key_exists("name", $json)) {
                $job->setName($json["name"]);
            }
            if (array_key_exists("company", $json)) {
                $job->setCompany($json["company"]);
            }
        }
    }

}
