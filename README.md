#About KRPaginatorBundle#

This is a simple bundle with 5 types of pagers (same as DataTables):

* *simple* - Next and Previous buttons;
* *numbers* - Number buttons;
* *simple_numbers* - Next, Previous, and Number buttons;
* *full* - First, Next, Previous, Last buttons;
* *full_numbers* - First, Next, Previous, Last, and Number buttons.

No configurations are necessary.

#Usage#

##In the controller##

```php
<?php
// Acme/Bundle/Controller/DefaultController.php

// ...

public function indexAction()
{
	$count = $repository->getAllUsersCount();

	$paginator = $this->get('kr_paginator')->buildPaginator('simple_numbers', [
		'totalItems' 	=> $count,	// required
		'limit' 	=> 5,		// optional (default is 10)
		'queryKey' 	=> 'p',		// optional (default is 'page')
		'adjacentCount'	=> 3		// optional (default is 2)
	]);

	$limit = $paginator->getLimit();
	$offset = $paginator->getOffset();

	$results = $repository->getAllUsers($limit, $offset);

	return $this->render('Bundle:Default:index.html.twig', [
		'results' 	=> $results,
		'paginator' 	=> $paginator->render()
	]);
}

```

##In the view##

```twig

{{ paginator|raw }}

<ul>
{% for result in results %}
	<li>{{ result.name }}</li>
{% endfor %}
</ul>

```

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require kr/kr-paginator-bundle "dev-master"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new KR\PaginatorBundle\KRPaginatorBundle(),
        );

        // ...
    }

    // ...
}
```
