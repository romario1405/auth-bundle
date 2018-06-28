<?php

namespace sonrac\Auth\Tests\App;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

/**
 * Class Kernel
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * Config extensions.
     *
     * @var string
     * @const
     */
    const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    /**
     * Get cache dir.
     *
     * @return string
     */
    public function getCacheDir(): string
    {
        return $this->getProjectDir().'/resources/cache/'.$this->environment;
    }

    /**
     * @inheritDoc
     */
    public function getProjectDir()
    {
        return __DIR__;
    }


    /**
     * Get log dir.
     *
     * @return string
     */
    public function getLogDir(): string
    {
        return $this->getProjectDir().'/resources/logs/';
    }

    /**
     * Register bundles.
     *
     * @return \Generator|iterable|\Symfony\Component\HttpKernel\Bundle\BundleInterface[]
     */
    public function registerBundles()
    {
        /** @var array $contents */
        $contents = require __DIR__.'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if (isset($envs['all']) || isset($envs[$this->getEnvironment()])) {
                yield new $class();
            }
        }
    }

    /**
     * Configure DI container.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param \Symfony\Component\Config\Loader\LoaderInterface        $loader
     *
     * @throws \Exception
     */
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->addResource(new FileResource($this->getProjectDir().'/config/bundles.php'));
        // Feel free to remove the "container.autowiring.strict_mode" parameter
        // if you are using symfony/dependency-injection 4.0+ as it's the default behavior
        $container->setParameter('container.autowiring.strict_mode', true);
        $container->setParameter('container.dumper.inline_class_loader', true);
        $confDir = $this->getProjectDir().'/config';
        $loader->load($confDir.'/{packages}/'.$this->getEnvironment().'/**/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{packages}/**/*'.self::CONFIG_EXTS, 'glob');

        $loader->load($confDir.'/{packages}/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{packages}/**/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}_'.$this->getEnvironment().self::CONFIG_EXTS, 'glob');
    }

    /**
     * Configure routes.
     *
     * @param \Symfony\Component\Routing\RouteCollectionBuilder $routes
     *
     * @throws \Symfony\Component\Config\Exception\FileLoaderLoadException
     */
    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $confDir = $this->getProjectDir().'/config';

        $routes->import($confDir.'/{routes}/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}/'.$this->getEnvironment().'/**/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}'.self::CONFIG_EXTS, '/', 'glob');
    }
}
