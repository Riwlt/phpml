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
        //TODO: implement
        return [];
    }
}