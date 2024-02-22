<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Firestore;

class FirestoreService
{
    protected $firestore;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(__DIR__.'/firebase.json')
            ->withDatabaseUri('https://example-chuphospital-default-rtdb.asia-southeast1.firebasedatabase.app/'); // Optional for Firestore

        $this->firestore = $factory->createFirestore();
    }

    public function getDocument($collection, $documentId)
    {
        $document = $this->firestore->database()->collection($collection)->document($documentId)->snapshot();

        if (!$document->exists()) {
            throw new \Exception('Document does not exist!');
        }

        return $document->data();
    }

    public function addDocument($collection, array $data)
    {   
        Log::info("addDocument : " . json_encode($data));
        $documentRef = $this->firestore->database()->collection($collection)->add($data);

        return $documentRef->id();
    }

    public function updateDocumentByLiveQueueId($collection, $liveQueueId, array $newData)
    {
        Log::info("updateDocument : " . json_encode($newData));
        // Query the collection for the document with the matching live_queue ID
        $query = $this->firestore->database()->collection($collection);
        $documents = $query->documents();
        // Log::info("query : " . json_encode($documents));

        foreach ($documents as $document) {
            $data = $document->data();

            // Check if the live_queue ID matches
            if ($data['data']['id'] == $liveQueueId) {
                //update
                $documentRef = $this->firestore->database()->collection($collection)->document($document->id());
                $documentRef->set($newData, ['merge' => true]);
                return $documentRef->id();
            }
        }

        // Return null if no matching document is found
        return null;
    }

    public function deleteDocumentByLiveQueueId($collection, $liveQueueId)
    {
        Log::info("deleteData : " . json_encode($liveQueueId));
        $query = $this->firestore->database()->collection($collection);
        $documents = $query->documents();

        foreach ($documents as $document) {

            $data = $document->data();
            if ($data['data']['id'] == $liveQueueId) {
                // Found the document, now delete it
                $documentRef = $this->firestore->database()->collection($collection)->document($document->id());
                $documentRef->delete();
                return $document->id(); // Return the document ID of the deleted document
            }
        }

        return null; // If no document was found with that 'id'
    }


}
