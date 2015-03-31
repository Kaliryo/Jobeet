<?php

namespace Ens\JobeetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ens\JobeetBundle\Entity\Category;

/**
 * Category controller
 */
class CategoryController extends Controller {

    public function showAction($slug) {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('ensJobeetBundle:Category')->findOneBySlug($slug);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }
        
        $total_jobs = $em->getRepository('ensJobeetBundle:Job')->countActiveJobs($category->getId());
        $jobs_per_page = $this->container->getParameter('max_jobs_on_category');
        $last_page = ceil($total_jobs / $jobs_per_page);
        $previous_page = $page > 1 ? $page - 1 : 1;
        $next_page = $page < $last_page ? $page + 1 : $last_page;
        $category->setActiveJobs($em->getRepository('ensJobeetBundle:Job')->getActiveJobs($category->getId(), $jobs_per_page, ($page - 1) * $jobs_per_page));

        return $this->render('ensJobeetBundle:Category:show.html.twig', array(
                    'category' => $category,
        ));
    }

}
