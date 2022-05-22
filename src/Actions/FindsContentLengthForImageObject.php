<?php

namespace Hyde\Framework\Actions;

use Hyde\Framework\Contracts\ActionContract;
use Hyde\Framework\Models\Image;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @see \Tests\Feature\FindsContentLengthForImageObjectTest
 */
class FindsContentLengthForImageObject implements ActionContract
{
    protected Image $image;

    /**
     * Testing adding console debug output.
     */
    protected OutputInterface $output;

    public function __construct(Image $image)
    {
        $this->image = $image;

        $this->output = new ConsoleOutput();
    }

    public function execute(): int
    {
        if ($this->isImageStoredRemotely()) {
            return $this->fetchRemoteImageInformation();
        }

        return $this->fetchLocalImageInformation();
    }

    protected function isImageStoredRemotely(): bool
    {
        return str_starts_with($this->image->getSource(), 'http');
    }

    protected function fetchRemoteImageInformation(): int
    {
        $this->write('<fg=gray> ></> <fg=gray>Fetching remote image information for '.basename($this->image->getSource()).'...</>');

        $response = Http::withHeaders([
            'User-Agent' => config('hyde.http_user_agent', 'RSS Request Client'),
        ])->head($this->image->getSource());

        $headers = $response->headers();

        if (array_key_exists('Content-Length', $headers)) {
            return (int) key(array_flip($headers['Content-Length']));
        }

        $this->write(' > <comment>Warning:</comment> Could not find content length in headers for '.basename($this->image->getSource().'!'));
        $this->write('           <fg=gray> Using default content length of 0. '.'</>');
        $this->write('           <fg=gray> Is the image path valid? '.($this->image->getSource()).'</>');

        return 0;
    }

    protected function fetchLocalImageInformation(): int
    {
        if (! file_exists($this->image->getSource())) {
            $this->write(' > <comment>Warning:</comment> Could not find image file at '.$this->image->getSource().'!');
            $this->write('         <fg=gray>   Using default content length of 0. '.'</>');

            return 0;
        }

        return filesize($this->image->getSource());
    }

    protected function write(string $string): void
    {
        $this->output->writeln($string);
    }
}
