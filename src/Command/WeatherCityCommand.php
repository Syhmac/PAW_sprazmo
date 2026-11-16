<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:city',
    description: 'Add a short description for your command',
)]
class WeatherCityCommand{
    public function __construct(
        private readonly LocationRepository $locationRepository,
        private readonly WeatherUtil $weatherUtil
    ){}
    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Country Code')] string $country,
        #[Argument('City Name')] string $city,
    ): int {
        $location = $this->locationRepository->findByCountryAndCity($country, $city);

        $measurements = $this->weatherUtil->getWeatherForLocation($location);
        $io->writeln(sprintf('Location: %s', $location->getName()));
        $io->table(['Date', 'Temperature', 'Pressure', 'Wind Speed', 'Wind Direction', 'Rain'], array_map(fn($m) => [
            $m->getDate()->format('Y-m-d'),
            $m->getTemperature(),
            $m->getPressure(),
            $m->getWindSpeed(),
            $m->getWindDirection(),
            $m->getRain(),
        ], $measurements));
        return Command::SUCCESS;
    }
}
