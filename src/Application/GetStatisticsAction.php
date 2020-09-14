<?php
declare(strict_types=1);

namespace SocialNetwork\Application;

use SocialNetwork\Domain\Post\Post;
use SocialNetwork\Domain\Statistic\DateTimePostStatistic;
use SocialNetwork\Domain\Statistic\UserStatistic;
use SocialNetwork\Domain\User\User;
use SocialNetwork\Domain\User\UserCollection;
use SocialNetwork\Domain\User\UserRepositoryInterface;

class GetStatisticsAction
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function run(): array
    {
        $users = $this->userRepository->findAll();

        return $this->calculate($users);
    }

    private function calculate(UserCollection $userCollection): array
    {
        /** @var UserStatistic[] $userStatistic */
        $userStatistics = [];

        $monthlyStatistic = new DateTimePostStatistic('F');
        $weeklyStatistic = new DateTimePostStatistic('W');

        $this->populateBaseStatistics(
            $userStatistics,
            $monthlyStatistic,
            $weeklyStatistic,
            $userCollection
        );

        return [
            'averageCharacterLengthOfPostsPerMonth' => $this->calculateAveragePostsLengthPerMonth($monthlyStatistic),
            'longestPostByCharacterLengthPerMonth' => $this->getLongestPostByCharacterLengthPerMonth($monthlyStatistic),
            'totalPostsByWeek' => $this->getTotalPostsByWeek($weeklyStatistic),
            'averageNumberOfPostsPerUserPerMonth' => $this->calculateAverageNumberOfPostsPerUserPerMonth($userStatistics)
        ];
    }

    private function populateBaseStatistics(
        &$userStatistics,
        &$monthlyStatistic,
        &$weeklyStatistic,
        UserCollection $userCollection
    ): void
    {
        /** @var User $user */
        foreach ($userCollection->getIterator() as $user) {
            $userStatistic = new UserStatistic(
                $user,
                new DateTimePostStatistic('F')
            );

            /** @var Post $post */
            foreach ($user->getPosts()->getIterator() as $post) {
                $userStatistic->addPost($post);
                $monthlyStatistic->addPost($post);
                $weeklyStatistic->addPost($post);
            }

            $userStatistics[$user->getId()] = $userStatistic;
        }
    }

    private function getLongestPostByCharacterLengthPerMonth(DateTimePostStatistic $monthlyStatistic): array
    {
        $longestPostByCharacterLengthPerMonth = [];
        foreach ($monthlyStatistic->getDateTimePosts() as $month => $monthlyPosts) {
            $longestPostByCharacterLengthPerMonth[$month] = $monthlyPosts->getLongestPost();
        }
        return $longestPostByCharacterLengthPerMonth;
    }

    private function getTotalPostsByWeek(DateTimePostStatistic $weeklyStatistic): array
    {
        $totalPostsByWeek = [];
        foreach ($weeklyStatistic->getDateTimePosts() as $weekNumber => $weeklyPosts) {
            $totalPostsByWeek[$weekNumber] = $weeklyPosts->getTotalPosts();
        }

        return $totalPostsByWeek;
    }

    /**
     * @param UserStatistic[] $userStatistics
     * @return float
     */
    private function calculateAverageNumberOfPostsPerUserPerMonth(array $userStatistics): float
    {
        $monthlyUsers = [];

        foreach ($userStatistics as $userId => $userStatistic) {
            foreach ($userStatistic->getPeriodPostStatistic()->getDateTimePosts() as $month => $userMonthlyStatistic) {
                $monthlyUsers[$month][$userId] = $userMonthlyStatistic->getTotalPosts();
            }
        }

        $sumAveragePerUser = 0;
        foreach ($monthlyUsers as $month => $users) {
            $sumAveragePerUser += array_sum($users) / count($users);
        }

        return round($sumAveragePerUser / count($monthlyUsers));
    }

    private function calculateAveragePostsLengthPerMonth(DateTimePostStatistic $monthlyStatistic): float
    {
        $monthlyAverage = [];

        foreach ($monthlyStatistic->getDateTimePosts() as $month => $monthlyPosts) {
            $monthlyAverage[$month] = $monthlyPosts->getTotalLength() / $monthlyPosts->getTotalPosts();
        }

        return round(array_sum($monthlyAverage) / count($monthlyAverage), 2);
    }
}