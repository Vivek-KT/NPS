<?= $this->extend("layouts/app_before") ?>
<?= $this->section("body") ?>
    <div class="container">
        <div class="card card-validation mx-auto mt-5">
            <div class="card-header">Survey Response</div>
            <?php if (session()->getFlashdata('response') !== NULL) : ?>
                <p style="color:green; font-size:18px;"  align="center"><?php echo session()->getFlashdata('response'); ?></p>
            <?php endif; ?>

            <?php if (isset($validation)) : ?>
                <p style="color:red; font-size:18px;" align="center"><?= $validation->showError('validatecheck') ?></p>
            <?php endif; ?>
            <div class="card-body">
          
            <form class="" action="<?= base_url('createsurveyanswer') ?>" method="post">
                
            <div class="vh-100 d-flex justify-content-center align-items-center">
            <div class="col-md-12">               

                <div class="bg-white shadow pb-5">
                    <div class="mb-4 row">
                    <div class="col-md-12 text-center">                       
                        <?php $imageProperties = ['src' => 'images/sa.jpg','class' => 'img-thumbnail','style' => 'height:300px;']; 
                            echo img($imageProperties); ?>
                            </div>
                            
                    </div>
                    <input type="hidden" id="emailid" name="emailid" value="<?php echo $getSurveyData['email_id']; ?>">
                    <input type="hidden" id="surveyid" name="surveyid" value="<?php echo $getSurveyData['campaignId']; ?>">
                    <input type="hidden" id="userid" name="userid" value="<?php echo $getSurveyData['userData']['id']; ?>">
                    <input type="hidden" id="tenantid" name="tenantid" value="<?php echo $getSurveyData['tenantData']['tenant_id']; ?>">

                    <?php foreach($getSurveyData['questionlist'] as $key => $questiondata) { ?>
                        <div class="row ml-4 q">
                    <div class="col-md-12">
                        <label><b><?php echo $questiondata['question_name']; ?></b></label>
                        <?php  if($key == 0 ) :  ?>
                    <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('RESULT_TextField0') ?></div><?php endif;  endif; ?>
                    </div>
                    <div class="col-md-12">
                    <input type="hidden" id="question_<?php echo $key; ?>" name="question[<?php echo $key; ?>]" value="<?php echo $questiondata['question_id']; ?>">
                    <?php if($questiondata['info_details'] == 'nps') { ?>
                        <table class="number_scale">
                            <tbody>
                                
                                <tr>
                                    <td><input type="radio" name="RESULT_TextField<?php echo $key; ?>" class="multiple_choice number_field" id="RESULT_TextField-<?php echo $key; ?>_1" value="1"><label for="RESULT_TextField-<?php echo $key; ?>_1"><span class="number">1</span></label></td>
                                    <td><input type="radio" name="RESULT_TextField<?php echo $key; ?>" class="multiple_choice number_field" id="RESULT_TextField-<?php echo $key; ?>_2" value="2"><label for="RESULT_TextField-<?php echo $key; ?>_2"><span class="number">2</span></label></td>
                                    <td><input type="radio" name="RESULT_TextField<?php echo $key; ?>" class="multiple_choice number_field" id="RESULT_TextField-<?php echo $key; ?>_3" value="3"><label for="RESULT_TextField-<?php echo $key; ?>_3"><span class="number">3</span></label></td>
                                    <td><input type="radio" name="RESULT_TextField<?php echo $key; ?>" class="multiple_choice number_field" id="RESULT_TextField-<?php echo $key; ?>_4" value="4"><label for="RESULT_TextField-<?php echo $key; ?>_4"><span class="number">4</span></label></td>
                                    <td><input type="radio" name="RESULT_TextField<?php echo $key; ?>" class="multiple_choice number_field" id="RESULT_TextField-<?php echo $key; ?>_5" value="5"><label for="RESULT_TextField-<?php echo $key; ?>_5"><span class="number">5</span></label></td>
                                    <td><input type="radio" name="RESULT_TextField<?php echo $key; ?>" class="multiple_choice number_field" id="RESULT_TextField-<?php echo $key; ?>_6" value="6"><label for="RESULT_TextField-<?php echo $key; ?>_6"><span class="number">6</span></label></td>
                                    <td class=""><input type="radio" name="RESULT_TextField<?php echo $key; ?>" class="multiple_choice number_field animate" id="RESULT_TextField-<?php echo $key; ?>_7" value="7"><label for="RESULT_TextField-<?php echo $key; ?>_7"><span class="number">7</span></label></td>
                                    <td class="highlight"><input type="radio" name="RESULT_TextField<?php echo $key; ?>" class="multiple_choice number_field animate" id="RESULT_TextField-<?php echo $key; ?>_8" value="8"><label for="RESULT_TextField-<?php echo $key; ?>_8"><span class="number">8</span></label></td>
                                    <td><input type="radio" name="RESULT_TextField<?php echo $key; ?>" class="multiple_choice number_field" id="RESULT_TextField-<?php echo $key; ?>_9" value="9"><label for="RESULT_TextField-<?php echo $key; ?>_9"><span class="number">9</span></label></td>
                                    <td><input type="radio" name="RESULT_TextField<?php echo $key; ?>" class="multiple_choice number_field" id="RESULT_TextField-<?php echo $key; ?>_10" value="10"><label for="RESULT_TextField-<?php echo $key; ?>_10"><span class="number">10</span></label></td>
                                </tr>
                                <tr>
                                    <td colspan="11">
                                    <div class="number_scale_label_left">Not Likely</div>
                                    <div class="number_scale_label_right">Very Likely</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <?php  }  else { ?>
                        <input type="text" id="nonratingvalue_<?php echo $key; ?>" name="nonratingvalue_<?php echo $key; ?>" value=""> 

                    <?php  } ?> 
                    </div>

                    </div>
                    
                    <?php  } ?>
                    


            <div class="text-center">
                    <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </div>
                
                
                </form>
            </div>
        </div>
    </div> 


<?= $this->endSection() ?>