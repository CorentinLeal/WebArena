<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Guilds Controller
 *
 * @property \App\Model\Table\GuildsTable $Guilds
 */
class GuildsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $guilds = $this->paginate($this->Guilds);

        $this->set(compact('guilds'));
        $this->set('_serialize', ['guilds']);
    }

    /**
     * View method
     *
     * @param string|null $id Guild id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $guild = $this->Guilds->get($id, [
            'contain' => ['Fighters']
        ]);

        $this->set('guild', $guild);
        $this->set('_serialize', ['guild']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $guild = $this->Guilds->newEntity();
        if ($this->request->is('post')) {
            $guild = $this->Guilds->patchEntity($guild, $this->request->data);
            if ($this->Guilds->save($guild)) {
                $this->Flash->success(__('The guild has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The guild could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('guild'));
        $this->set('_serialize', ['guild']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Guild id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $guild = $this->Guilds->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $guild = $this->Guilds->patchEntity($guild, $this->request->data);
            if ($this->Guilds->save($guild)) {
                $this->Flash->success(__('The guild has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The guild could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('guild'));
        $this->set('_serialize', ['guild']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Guild id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $guild = $this->Guilds->get($id);
        if ($this->Guilds->delete($guild)) {
            $this->Flash->success(__('The guild has been deleted.'));
        } else {
            $this->Flash->error(__('The guild could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
