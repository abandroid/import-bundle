<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\ImportBundle\Controller;

use Endroid\Import\Importer\ImporterInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportController
{
    private $importers;

    public function __construct(iterable $importers)
    {
        $this->importers = $importers;
    }

    /**
     * @Route("/{name}", name="import")
     */
    public function __invoke(string $name): Response
    {
        $importer = $this->getImporter($name);
        $importer->import();

        return new Response('Done');
    }

    protected function getImporter(string $name): ImporterInterface
    {
        foreach ($this->importers as $importer) {
            if ($importer->getName() === $name) {
                return $importer;
            }
        }

        return null;
    }
}
