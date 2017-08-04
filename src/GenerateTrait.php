<?php

namespace PHPCasts\Console;

use Symfony\Component\Console\Question\ConfirmationQuestion;

trait GenerateTrait
{
    public function generate($desc, $data, $input, $output)
    {
        if (!is_writable(dirname($desc))) {
            throw new \Exception('Access deny');
        }

        if (file_exists($desc)) {
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion('The file is exists, you want to override? (y|n)', false);

            if (!$helper->ask($input, $output, $question)) {
                return;
            }
        }

        file_put_contents($desc, $data);
    }
}