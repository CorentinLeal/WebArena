<?php
/**
 * Created by PhpStorm.
 * User: corentin
 * Date: 27/10/16
 * Time: 22:17
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class PlayersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Auth');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('add');
    }

    public function index()
    {
        $this->set('players', $this->Players->find('all'));
    }

    public function view($id)
    {
        $players = $this->Players->get($id);
        $this->set(compact('players'));
    }

    public function add()
    {
        $player = $this->Players->newEntity();
        if ($this->request->is('post')) {
            $player = $this->Players->patchEntity($player, $this->request->data);
            if ($this->Players->save($player)) {
                $this->Flash->success(__("The player has been saved."));
                return $this->redirect(['controller' => 'Arenas', 'action' => 'index']);
            }
            $this->Flash->error(__("Impossible to add user."));
        }
        $this->set('player', $player);
    }

}