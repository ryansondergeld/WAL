<?php

namespace App\Classes;

use Livewire\Wireable;

class Move implements Wireable
{
    private ?string $turn;
    private ?string $player;
    private ?string $action;
    private ?string $board;

    public function __construct($turn, $player, $action, $board)
    {
        $this->turn = $turn;
        $this->player = $player;
        $this->action = $action;
        $this->board = $board;
    }
    public function toLivewire(): array
    {
        return
            [
                'turn' => $this->turn,
                'player' => $this->player,
                'action' => $this->action,
                'board' => $this->board,
            ];
    }

    public static function fromLivewire($value): static
    {
        $turn = $value['turn'];
        $player = $value['player'];
        $action = $value['action'];
        $board = $value['board'];

        return new static($turn, $player, $action, $board);
    }

    public function get_turn(): string { return $this->turn; }
    public function get_player() : string { return $this->player; }
    public function get_action() : string { return $this->action; }
    public function get_board() : string { return $this->board; }
    public function set_turn($turn){ $this->turn = $turn; }
    public function set_player($player){ $this->player = $player; }
    public function set_action($action){ $this->action = $action; }
    public function set_board($board){ $this->board = $board; }
}
