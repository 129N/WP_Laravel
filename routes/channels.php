<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel(
  'emergency.event.{event_code}.participant.{participant_id}',
  function ($user, $event_code, $participant_id) {
      return true; // pass
  }
);


// const roomId = `event:${event_code}:participant:${participant_id}`;