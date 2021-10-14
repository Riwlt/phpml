<?php

declare(strict_types=1);

namespace App\Extractor\Numbers;

use App\Extractor\DataExtractorInterface;
use Rubix\ML\Classifiers\MultilayerPerceptron;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\NeuralNet\ActivationFunctions\LeakyReLU;
use Rubix\ML\NeuralNet\Layers\Activation;
use Rubix\ML\NeuralNet\Layers\Dense;
use Rubix\ML\NeuralNet\Layers\Dropout;
use Rubix\ML\NeuralNet\Optimizers\Adam;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\Pipeline;
use Rubix\ML\Transformers\ImageResizer;
use Rubix\ML\Transformers\ImageVectorizer;
use Rubix\ML\Transformers\ZScaleStandardizer;

class DataExtractor implements DataExtractorInterface
{
    public function extract(): array
    {
        $samples = $labels = [];

        chdir('..');
        for ($label = 0; $label < 10; $label++) {
            foreach (glob("src/training/$label/*.png") as $file) {
                $samples[] = [imagecreatefrompng($file)];
                $labels[] = "#$label";
            }
        }
        $dataset = new Labeled($samples, $labels);

        $batchSize = 1024;

        $estimator = new PersistentModel(
            new Pipeline([
                new ImageResizer(28, 28),
                new ImageVectorizer(true),
                new ZScaleStandardizer(),
            ], new MultilayerPerceptron([
                new Dense(100),
                new Activation(new LeakyReLU()),
                new Dropout(0.2),
                new Dense(100),
                new Activation(new LeakyReLU()),
                new Dropout(0.2),
                new Dense(100),
                new Activation(new LeakyReLU()),
                new Dropout(0.2),
            ],
                $batchSize,
                new Adam(0.0001))),
            new Filesystem('mnist.rbx', true)
        );

        /** @var PersistentModel $estimator */
        $estimator->train($dataset);

        $extractor = new CSV('progress.csv', true);

        $extractor->export($estimator->steps());

        return [];
    }
}