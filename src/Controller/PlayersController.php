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
        //$this->loadComponent('Auth');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['add', 'logout']);
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
                $this->Flash->success(__("Joueur enregistré !"));
                return $this->redirect(['controller' => 'Arenas', 'action' => 'index']);
            }
            $this->Flash->error(__("Impossible d'ajouter un utilisateur."));
        }
        $this->set('player', $player);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $player = $this->Auth->identify();
            
            if ($player) {
                $this->Auth->setUser($player);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Email ou mot de passe invalide'));
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

}