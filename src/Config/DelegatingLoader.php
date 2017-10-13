<?php

namespace AppLib\Config;

use Symfony\Component\Config\Loader\FileLoader;

class DelegatingLoader extends FileLoader
{
	/**
     * Constructor.
     *
     * @param LoaderResolverInterface $resolver A LoaderResolverInterface instance
     */
    public function __construct(LoaderResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
        if (false === $loader = $this->resolver->resolve($resource, $type)) {
            throw new FileLoaderLoadException($resource, null, null, null, $type);
        }

        return $loader->load($resource, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return false !== $this->resolver->resolve($resource, $type);
    }
}
