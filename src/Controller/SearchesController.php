<?php
namespace App\Controller;

use App\Controller\AppController;

use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * Searches Controller
 *
 * @property \App\Model\Table\SearchesTable $Searches
 */
class SearchesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Phrases']
        ];
        $searches = $this->paginate($this->Searches);

        $this->set(compact('searches'));
        $this->set('_serialize', ['searches']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Search id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $search = $this->Searches->get($id);
        if ($this->Searches->delete($search)) {
            $this->Flash->success(__('The search has been deleted.'));
        } else {
            $this->Flash->error(__('The search could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function add()
	{
		echo "<h1><center>Only For Test</center></h1>";
		$this->autoRender = false;
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
		
		$params = [
			'q' 			=> 'takeover bid',
			'since_id' 		=> '762682343257731072', 
			// 'max_id'		=>'250126199840518145',
			'result_type'	=> 'mixed',
			'count'			=> 100
		];	
		pr($params);		
        $data = $connection->get('search/tweets', $params)->statuses;
		echo count($data);
		pr($data);
		
		// $params = ['q' => '#cakephp' ,'count' => '10', 'lang'=>'ja'];
		// pr($params);		
        // $data = $connection->get('search/tweets', $params)->statuses;
		// pr($data);	
		
			$data = [
				'phrase_id'	=> rand(1, 2),
				'count'		=> rand (10,100),
			];
			$search = $this->Searches->newEntity($data);
			$this->Searches->save($search);			
			
	}

	
}
