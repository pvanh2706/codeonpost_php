<?php
$CI =& get_instance();
$CI->load->model('Sales_return_model', 'sales_return');
$CI->load->model('Payment_types_model', 'payment_types');

$sales_return = $CI->sales_return->get_return_details($return_id);
$return_payments = $CI->sales_return->get_payments($return_id);
$payment_types = $CI->payment_types->get_all();

// Tính toán
$grand_total = $sales_return->grand_total;
$payment_amount = $sales_return->paid_amount;
$due_amount = $grand_total - $payment_amount;
?>get_instance();
$CI->load->model('Sales_return_model', 'sales_return');
$CI->load->model('Payment_types_model', 'payment_types');

$sales_return = $CI->sales_return->get_details($return_id);
$return_payments = $CI->sales_return->get_payments($return_id);
$payment_types = $CI->payment_types->get_all();

// Tính toán
$grand_total = $sales_return->grand_total;
$payment_amount = $sales_return->paid_amount;
$due_amount = $grand_total - $payment_amount;
?>

<div class="modal fade" id="view_payments_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('view_payments'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><?php echo $this->lang->line('customer_information'); ?></h5>
                            </div>
                            <div class="card-body">
                                <p><strong><?php echo $this->lang->line('customer_name'); ?>:</strong> <?php echo $sales_return->customer_name; ?></p>
                                <p><strong><?php echo $this->lang->line('customer_mobile'); ?>:</strong> <?php echo $sales_return->customer_mobile; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><?php echo $this->lang->line('sales_information'); ?></h5>
                            </div>
                            <div class="card-body">
                                <p><strong><?php echo $this->lang->line('invoice'); ?>:</strong> <?php echo $sales_return->return_code; ?></p>
                                <p><strong><?php echo $this->lang->line('date'); ?>:</strong> <?php echo date('d-m-Y', strtotime($sales_return->return_date)); ?></p>
                                <p><strong><?php echo $this->lang->line('grand_total'); ?>:</strong> <?php echo number_format($grand_total, 0); ?></p>
                                <p><strong><?php echo $this->lang->line('paid_amount'); ?>:</strong> <?php echo number_format($payment_amount, 0); ?></p>
                                <p><strong><?php echo $this->lang->line('due_amount'); ?>:</strong> <?php echo number_format($due_amount, 0); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><?php echo $this->lang->line('payments'); ?></h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('payment_date'); ?></th>
                                            <th><?php echo $this->lang->line('payment_type'); ?></th>
                                            <th><?php echo $this->lang->line('paid_amount'); ?></th>
                                            <th><?php echo $this->lang->line('payment_note'); ?></th>
                                            <th><?php echo $this->lang->line('created_by'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($return_payments)) : ?>
                                            <?php foreach ($return_payments as $payment) : ?>
                                                <tr>
                                                    <td><?php echo date('d-m-Y', strtotime($payment->payment_date)); ?></td>
                                                    <td><?php echo $payment->payment_type; ?></td>
                                                    <td><?php echo number_format($payment->payment, 0); ?></td>
                                                    <td><?php echo $payment->payment_note; ?></td>
                                                    <td><?php echo $payment->created_by; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="5" class="text-center"><?php echo $this->lang->line('no_records_found'); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
