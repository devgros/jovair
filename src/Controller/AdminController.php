<?php 

namespace App\Controller;

use AlterPHP\EasyAdminExtensionBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
	public function notificationsAction()
	{
		$alertes =  $this->getDoctrine()->getManager()->getRepository('App:Alerte')->findAll();
		return $this->render("easy_admin/notifications.html.twig", array('alertes' => $alertes));
	}

	protected function createSearchQueryBuilder($entityClass, $searchQuery,
        array $searchableFields, $sortField = null, $sortDirection = null, $dqlFilter = null
    ) {
        $queryBuilder = $this->get('easyadmin.query_builder')->createSearchQueryBuilder($this->entity, $searchQuery, $sortField, $sortDirection, $dqlFilter);
        $lowerSearchQuery = mb_strtolower($searchQuery);

        $queryParameters = [];
        $alreadyJoin = array();
        foreach ($this->entity['search']['fields'] as $name => $metadata) {
            if ('association' === $metadata['dataType']) {
                if (false === array_key_exists('searchField', $metadata)) {
                    throw new MissingSearchAssociationException($this->entity['name'], $name);
                }

                // Join the associated entity and search on the given field
                $searchFields = $metadata['searchField'];
                if (!in_array(sprintf('entity.%s', $name), $alreadyJoin)) {
				    $queryBuilder->leftJoin(sprintf('entity.%s', $name), $name);
				    $alreadyJoin[] = sprintf('entity.%s', $name);
				}
                

                // here is the change
                if (!is_array($searchFields)) {
                    $searchFields = [$searchFields];
                }
                foreach ($searchFields as $searchField) {
                	if (strpos($searchField, ".") !== false) 
					{
					    $searchFieldTab =explode(".", $searchField);
					    if(sizeof($searchFieldTab) <= 2){
					    	$parent_name = $name;			
						    $subName = $searchFieldTab[0];
						    $searchField = $searchFieldTab[1];

						    if (!in_array(sprintf('%s.%s', $parent_name, $subName), $alreadyJoin)) {
						    	$queryBuilder->leftJoin(sprintf('%s.%s', $parent_name, $subName), $subName);
							    $alreadyJoin[] = sprintf('%s.%s', $parent_name, $subName);
							}
					    }else{
					    	$parent_name = $name;			
					    	$subTable = $searchFieldTab[0];
						    $subName = $searchFieldTab[1];
						    $searchField = $searchFieldTab[2];

						    if (!in_array(sprintf('%s.%s', $parent_name, $subTable), $alreadyJoin)) {
						    	$queryBuilder->leftJoin(sprintf('%s.%s', $parent_name, $subTable), $subTable);
							    $alreadyJoin[] = sprintf('%s.%s', $parent_name, $subTable);
							}

						    if (!in_array(sprintf('%s.%s', $subTable, $subName), $alreadyJoin)) {
						    	$queryBuilder->leftJoin(sprintf('%s.%s', $subTable, $subName), $subName);
							    $alreadyJoin[] = sprintf('%s.%s', $subTable, $subName);
							}
					    }

					    $queryBuilder->orWhere(sprintf('LOWER(%s.%s) LIKE :fuzzy_query', $subName, $searchField));
	                    $queryParameters['fuzzy_query'] = '%'.$lowerSearchQuery.'%';

	                    $queryBuilder->orWhere(sprintf('LOWER(%s.%s) IN (:words_query)', $subName, $searchField));
	                    $queryParameters['words_query'] = explode(' ', $lowerSearchQuery);
					}else{
						$queryBuilder->orWhere(sprintf('LOWER(%s.%s) LIKE :fuzzy_query', $name, $searchField));
	                    $queryParameters['fuzzy_query'] = '%'.$lowerSearchQuery.'%';

	                    $queryBuilder->orWhere(sprintf('LOWER(%s.%s) IN (:words_query)', $name, $searchField));
	                    $queryParameters['words_query'] = explode(' ', $lowerSearchQuery);
					}
                }
            }
        }

	    if (0 !== count($queryParameters)) {
	        $queryBuilder->setParameters($queryParameters);
	    }

        return $queryBuilder;
    }
}