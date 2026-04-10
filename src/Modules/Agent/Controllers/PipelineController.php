<?php
namespace IMO\Modules\Agent\Controllers;

use IMO\Core\Controller;
use IMO\Core\Security\Auth;
use IMO\Core\Database\Connection;
use IMO\Core\Security\Encrypter;
use Exception;

class PipelineController extends Controller
{
    public function index(): void
    {
        if (!Auth::check()) {
            http_response_code(401);
            echo "Non-authorized access.";
            exit;
        }

        try {
            $pdo = Connection::getInstance();
            $user = Auth::user();
            
            $whereClause = ($user['role'] === 'agent') ? "assigned_user_id IS NULL OR assigned_user_id = :uid" : "1=1";
            
            $stmt = $pdo->prepare("SELECT * FROM leads WHERE $whereClause ORDER BY score DESC");
            if ($user['role'] === 'agent') {
                $stmt->execute(['uid' => $user['id']]);
            } else {
                $stmt->execute();
            }
            $rawLeads = $stmt->fetchAll();

            $leads = [
                'new' => [],
                'contacted' => [],
                'qualified' => [],
                'converted' => []
            ];

            foreach ($rawLeads as $lead) {
                try {
                    $pii = json_decode(Encrypter::decrypt($lead['encrypted_payload']), true);
                    $lead['name']  = $pii['name'] ?? 'N/A';
                    $lead['email'] = $pii['email'] ?? 'N/A';
                } catch (Exception $e) {
                    $lead['name'] = 'HIPAA Masked';
                    $lead['email'] = 'HIPAA Masked';
                }
                
                $status = $lead['status'] ?? 'new';
                if (!isset($leads[$status])) $status = 'new';
                $leads[$status][] = $lead;
            }

            $this->view('Agent/Views/pipeline', [
                'leads' => $leads,
                'user'  => $user
            ]);

        } catch (Exception $e) {
            $this->view('Landing/Views/404');
        }
    }
}
