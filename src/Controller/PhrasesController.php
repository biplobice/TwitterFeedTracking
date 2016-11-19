<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Phrases Controller
 *
 * @property \App\Model\Table\PhrasesTable $Phrases
 */
class PhrasesController extends AppController
{	

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $phrases = $this->paginate($this->Phrases);

        $this->set(compact('phrases'));
        $this->set('_serialize', ['phrases']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $phrase = $this->Phrases->newEntity();
        if ($this->request->is('post')) {
            $phrase = $this->Phrases->patchEntity($phrase, $this->request->data);
            if ($this->Phrases->save($phrase)) {
                $this->Flash->success(__('The phrase has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The phrase could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('phrase'));
        $this->set('_serialize', ['phrase']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Phrase id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $phrase = $this->Phrases->get($id);
        if ($this->Phrases->delete($phrase)) {
            $this->Flash->success(__('The phrase has been deleted.'));
        } else {
            $this->Flash->error(__('The phrase could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

	public function report() 
	{
		$phrases = $this->Phrases->find('list')
			->select(['id', 'name'])
			->toList();

        $data = [];
		foreach ($phrases as $id => $phrase) {

            $this->loadModel('Searches');
            /*================ For advance features ===============*/
            /*$yearlySearches = $this->Searches
                ->find()
                ->select(['total_count' => 'SUM(count)', 'year' => 'YEAR(created)'])
                ->group(['year'])
                ->hydrate(false)
                ->toArray();

            // Get searches by weekly
            $weeklySearches = $this->Searches
                ->find()
                ->select(['total_count' => 'SUM(count)', 'day_of_week' => 'DAYOFWEEK(created)'])
                ->group(['day_of_week'])
                ->hydrate(false)
                ->toArray();*/
            /*=====================================================*/


			$searches = $this->Searches->find()
				->select(['count', 'created'])
				->where(['phrase_id' => $id, 'created >=' => date('Y-m-d H:i:s', strtotime('-1 hour'))])
				->order(['created' => 'DESC']);
			// set dynamic chart data
            $labels = [];
            $counts = [];
            foreach ($searches as $search) {
                $labels[] 	= $search['created']->nice();
                $counts[]	= $search['count'];
            }
            $data[$phrase] = ['labels' => $labels, 'counts' => $counts ];
		}

		$this->set(compact('phrases', 'data'));
	}




}
