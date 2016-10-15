<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Surroundings Controller
 *
 * @property \App\Model\Table\SurroundingsTable $Surroundings
 */
class SurroundingsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $surroundings = $this->paginate($this->Surroundings);

        $this->set(compact('surroundings'));
        $this->set('_serialize', ['surroundings']);
    }

    /**
     * View method
     *
     * @param string|null $id Surrounding id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $surrounding = $this->Surroundings->get($id, [
            'contain' => []
        ]);

        $this->set('surrounding', $surrounding);
        $this->set('_serialize', ['surrounding']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $surrounding = $this->Surroundings->newEntity();
        if ($this->request->is('post')) {
            $surrounding = $this->Surroundings->patchEntity($surrounding, $this->request->data);
            if ($this->Surroundings->save($surrounding)) {
                $this->Flash->success(__('The surrounding has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The surrounding could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('surrounding'));
        $this->set('_serialize', ['surrounding']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Surrounding id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $surrounding = $this->Surroundings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $surrounding = $this->Surroundings->patchEntity($surrounding, $this->request->data);
            if ($this->Surroundings->save($surrounding)) {
                $this->Flash->success(__('The surrounding has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The surrounding could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('surrounding'));
        $this->set('_serialize', ['surrounding']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Surrounding id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $surrounding = $this->Surroundings->get($id);
        if ($this->Surroundings->delete($surrounding)) {
            $this->Flash->success(__('The surrounding has been deleted.'));
        } else {
            $this->Flash->error(__('The surrounding could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
