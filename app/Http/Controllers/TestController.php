<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    protected $firestoreService;
    protected $CREATED = 'live_queue_created';
    protected $UPDATED = 'live_queue_updated';
    protected $DELETED = 'live_queue_deleted';

    public function __construct(FirestoreService $firestoreService)
    {
        $this->firestoreService = $firestoreService;
    }

    public function addData(Request $request)
    {
        $documentId = null;

        if ($request['payload']['event'] == $this->CREATED) {
            $documentId = $this->firestoreService->addDocument('live_queue', $request['payload']);
        } elseif ($request['payload']['event'] == $this->UPDATED) {
            // The live_queue ID should be part of your payload data
            $liveQueueId = $request['payload']['data']['id'];
            
            // Prepare the data to update, excluding the event and live_queue ID fields
            $data = $request['payload']['data'];
            $dataToUpdate['data'] = [
                'state' => $data['state'],
                'state_name' => $data['state_name'],
                'updated_at' => $data['updated_at'],
            ];

            // Perform the update
            $documentId = $this->firestoreService->updateDocumentByLiveQueueId('live_queue', $liveQueueId, $dataToUpdate);
            // return response()->json(['message' => 'Document updated successfully', 'documentId' => $documentId]);
        } elseif ($request['payload']['event'] == $this->DELETED) {
            // The 'id' field within the 'data' part of the payload is used to find the Firestore document
            $liveQueueId = $request['payload']['data']['id'];

            // Call the service method to delete the document by live_queue ID
            $documentId = $this->firestoreService->deleteDocumentByLiveQueueId('live_queue', $liveQueueId);
        }

        Log::info("message: " . json_encode($request->all()));
        
        return response()->json(['documentId' => $documentId]);
    }

    public function showLiveQueue()
    {
        return view('live_queue');
    }

}
