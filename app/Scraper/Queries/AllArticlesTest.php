<?php

namespace App\Scraper\Queries;

use App\Scraper\Queries\AllArticles;
use Illuminate\Support\Collection;
use App\Testing\TestCase;

class AllArticlesTest extends TestCase
{
    public function testScrapeArticles()
    {
        // Mocking the ScrapeArticlesList class
        $fakeScrapeArticlesList = $this->getMockBuilder(ScrapeArticlesList::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Setting up a fake list of article URLs
        $fakeArticleUrls = [
            'https://example.com/article1',
            'https://example.com/article2',
            // Add more fake URLs as needed
        ];

        // Mocking the return value of the get method of the fake ScrapeArticlesList
        $fakeScrapeArticlesList->expects($this->once())
            ->method('get')
            ->willReturn($fakeArticleUrls);

        // Mocking the ScrapeArticle class
        $fakeScrapeArticle = $this->getMockBuilder(ScrapeArticle::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Mocking the return value of the get method of the fake ScrapeArticle
        $fakeScrapeArticle->method('get')->willReturn('Fake article content');

        // Mocking the setup method of the ScrapeArticle class to return the fake instance
        $this->getMockBuilder(ScrapeArticle::class)
            ->disableOriginalConstructor()
            ->setMethods(['setup'])
            ->getMock()
            ->method('setup')
            ->willReturn($fakeScrapeArticle);

        // Creating an instance of AllArticles with organizationId = 123
        $allArticles = AllArticles::setup(123);

        // Setting up the AllArticles instance to use the fake ScrapeArticlesList
        $reflection = new ReflectionClass($allArticles);
        $property = $reflection->getProperty('scrapeArticlesList');
        $property->setAccessible(true);
        $property->setValue($allArticles, $fakeScrapeArticlesList);

        // Calling the scrapeArticles method
        $result = $allArticles->scrapeArticles();

        // Asserting that the result is an instance of Collection
        $this->assertInstanceOf(Collection::class, $result);

        // Asserting that the result contains the fake article content
        foreach ($result as $articleContent) {
            $this->assertEquals('Fake article content', $articleContent);
        }
    }
}
