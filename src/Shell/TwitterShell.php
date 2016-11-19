<?php
namespace App\Shell;

use Cake\Console\Shell;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterShell extends Shell
{
	public function initialize()
	{
		parent::initialize();
		$this->loadModel('Phrases');
		$this->loadModel('Searches');
	}
	
	public function main()
	{
		$this->out('Hello Twitter');
		$this->tweetSearch();
		$this->out('=======================');
	}
	
	public function tweetSearch()
	{
		$this->out('Tweet searching started');
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
		
		$phrases = $this->Phrases->find('list')
			->toArray();				
		foreach ($phrases as $id => $phrase)
		{
			$this->out('Searching for phrase: ' . $phrase);
			$params = [
				'q' 			=> $phrase,
				// 'since_id' 		=> '24012619984051000', 
				// 'max_id'		=>'250126199840518145',
				'result_type'	=> 'mixed',
				'count'			=> 100
			];			
	        $data = $connection->get('search/tweets', $params)->statuses;
			$count = count($data);
			$this->out('Have found: ' . $count . 'matches.');

			$data = [
				'phrase_id'	=> $id,
				'count'		=> $count,
			];
			$search = $this->Searches->newEntity($data);
			$this->Searches->save($search);
			$this->out('-----------------------');
		}		
	}
}
