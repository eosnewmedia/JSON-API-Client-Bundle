<?php
declare(strict_types=1);

namespace Enm\Bundle\JsonApi\Client;

use Enm\Bundle\JsonApi\Client\DependencyInjection\Compiler\ApiClientPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class EnmJsonApiClientBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ApiClientPass());
    }
}
