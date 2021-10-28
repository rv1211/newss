<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forgot_password extends CI_Controller
{
    public $data = [];
    /***
     *  construct
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Forgot_password_model', 'Forgot_pwd');
        // $this->userAccount = $this->session->userdata('userAccount');
    }
    public function index()
    {
        $this->load->view('front/layout/front-headerlinks');
        $this->load->view('front/layout/front-header');
        $this->load->view('front/forgot_password/forgot_password');
        $this->load->view('front/layout/front-footer');
    }
    public function forgot_pwd_post()
    {
        if ($this->input->post()) {
            $validation = [
                ['field' => 'email', 'label' => 'email', 'rules' => 'required|valid_email'],
            ];
            $this->form_validation->set_rules($validation);
            if ($this->form_validation->run() == false) {
                $this->data['errors'] = $this->form_validation->error_array();
                $this->load->view('front/layout/front-headerlinks');
                $this->load->view('front/layout/front-header');
                $this->load->view('front/forgot_password/forgot_password', $this->data);
                $this->load->view('front/layout/front-footer');
            } else {
                $email = $this->input->post('email');
                $user_emai_exist = $this->Forgot_pwd->check_exist($email);
                if ($user_emai_exist) {
                    $string = $this->generateRandomString();
                    $email_update = [
                        'string' => $string,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    $update_result = $this->Common_model->update($email_update, 'user_email', array('email' => $email));
                    if ($update_result) {
                        $resetlink = base_url('reset') . "/" . $string;
                        $this->load->helper('mailhelper');
                        $to = $email;
                        $subject = "Reset Password";
                        $messageBody = resetpwdBody($resetlink);
                        $mail = simpleMail($to, $subject, $messageBody);
                        $mailLog['toMail'] = $to;
                        $mailLog['type'] = 'Update';
                        $mailLog['MailBody'] = $messageBody;
                        $mailLog['MailResponse'] = $mail;
                        file_put_contents(APPPATH . 'logs/mailLog/' . date("d-m-Y") . '_maillog.txt', "\n\n---------- Forgote Password -------------\n" . print_r($mailLog, true), FILE_APPEND);
                        if ($mail) {
                            $this->load->view('admin/template/header');
                            $this->load->view('admin/template/sidebar');
                            $this->load->view('front/forgot_password/forgot_password', $this->data);
                            $this->load->view('admin/template/footer');
                            $this->session->set_flashdata('message', 'success sending mail check your Mail');
                            redirect('forgot-password', 'refresh');
                        } else {
                            $this->session->set_flashdata('error', 'Mail can not be send');
                            redirect('forgot-password');
                        }
                    } else {
                        $this->load->view('admin/template/header');
                        $this->load->view('admin/template/sidebar');
                        $this->load->view('front/forgot_password/forgot_password', $this->data);
                        $this->load->view('admin/template/footer');
                        $this->session->set_flashdata('error', 'Cannot find your email');
                        redirect('forgot-password');
                    }
                } else {
                    $email_exist = $this->Forgot_pwd->check_valid_email($email);
                    if ($email_exist == 'sender') {
                        // 0 = SENDER
                        $type = '0';
                    } else {
                        // 1 = USER
                        $type = '1';
                    }
                }
                if ($email_exist != '') {
                    $string = $this->generateRandomString();
                    $email_insert = [
                        'email' => $this->input->post('email'),
                        'string' => $string,
                        'type' => $type,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    $email_data = $this->Common_model->insert($email_insert, "user_email");

                    if ($email_data) {
                        $resetlink = base_url('reset') . "/" . $string;
                        $this->load->helper('mailhelper');
                        $to = $email;
                        $subject = "Reset Password";
                        $messageBody = resetpwdBody($resetlink);
                        $mail = simpleMail($to, $subject, $messageBody);

                        $mailLog['toMail'] = $to;
                        $mailLog['type'] = 'Insert';
                        $mailLog['MailBody'] = $messageBody;
                        $mailLog['MailResponse'] = $mail;
                        file_put_contents(APPPATH . 'logs/mailLog/' . date("d-m-Y") . '_maillog.txt', "\n\n---------- Forgote Password -------------\n" . print_r($mailLog, true), FILE_APPEND);

                        if ($mail) {
                            $this->load->view('admin/template/header');
                            $this->load->view('admin/template/sidebar');
                            $this->load->view('front/forgot_password/forgot_password', $this->data);
                            $this->load->view('admin/template/footer');
                            $this->session->set_flashdata('message', 'success sending mail check your Mail');
                            redirect('forgot-password', 'refresh');
                        } else {
                            $this->session->set_flashdata('error', 'Mail can not be send');
                            redirect('forgot-password');
                        }
                    } else {
                        $this->load->view('admin/template/header');
                        $this->load->view('admin/template/sidebar');
                        $this->load->view('front/forgot_password/forgot_password', $this->data);
                        $this->load->view('admin/template/footer');
                        $this->session->set_flashdata('error', 'Cannot find your email');
                        redirect('forgot-password');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Cannot find your email');
                    redirect('forgot-password');
                }
            }
        } else {
            $this->load->view('admin/template/header');
            $this->load->view('admin/template/sidebar');
            $this->load->view('front/forgot_password/forgot_password', $this->data);
            $this->load->view('admin/template/footer');
            $this->session->set_flashdata('error', 'Something wents to wrong');
            redirect('login');
        }
    }
    private function generateRandomString($length = 16)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
