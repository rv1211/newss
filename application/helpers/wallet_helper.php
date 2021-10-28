<?php
class wallet
{
    public static function refund_wallet($order_id)
    {
        $CI = &get_instance();

        $CI->load->model('Create_singleorder_awb');

        $order_data = $CI->db->select('fom.*, sm.wallet_balance')->from('forward_order_master as fom')->where('fom.is_delete', '1')->where('fom.id', $order_id)->join('sender_master as sm', 'fom.sender_id = sm.id')->get()->row_array();
        $log_data['order_data_info'] = $order_data;

        if (empty($order_data)) {
            $error = "No Order Found !!!";
        } else {
            $success = $error = "";
            $refund_amout = $order_data['paid_amount'];
            try {
                $CI->db->trans_start(false);
                $wallet_balance = $order_data['wallet_balance'];
                $update_amount = $wallet_balance + $refund_amout;

                $log_data['wallet_balance_in_wallet'] = $wallet_balance;
                $log_data['update_amount_in_wallet'] = $update_amount;
                $data = [
                    'wallet_balance' => $update_amount,
                ];
                $CI->db->where('id', $order_data['sender_id'])->update('sender_master', $data);
                $log_data['update_amount_update_query'] = $CI->db->last_query();

                $wallet_trancection_log = [
                    'sender_id' => $order_data['sender_id'],
                    'order_id' => $order_id,
                    'credit' => $refund_amout,
                    'runningbalance' => $update_amount,
                    'remarks' => "Refund Credited Of Order id :" . $order_data['order_no'] . ", Awb Number :" . $order_data['awb_number'],
                ];


                $CI->Create_singleorder_awb->update_tranction($wallet_trancection_log);

                $log_data['wallet_transaction'] = $wallet_trancection_log;

                $CI->db->trans_complete();

                if ($CI->db->trans_status() === false) {
                    $CI->db->trans_rollback();
                } else {
                    $success = "Amount Credited Successfully";
                    $CI->db->trans_commit();
                }

                if (!empty($db_error)) {
                    $log_data['throw_error'] = $db_error;
                    throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                }
            } catch (Exception $th) {
                $log_data['catch_error'] = $th->getMessage();
                $error = $th->getMessage();
            }
        }
        file_put_contents(APPPATH . 'logs/wallet_transaction/' . date("d-m-Y") . '_refund_wallet_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
        if ($success != "") {
            return ['1' => $success];
        } else {
            return ['0' => $error];
        }
    }
}
