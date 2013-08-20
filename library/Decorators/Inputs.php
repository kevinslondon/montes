<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kevin Saunders
 * Date: 18/05/12
 */
class Decorators_Inputs extends Zend_Form_Decorator_Abstract
{
    protected $_format = '
    <div class="element">
        <div class="label_col">
            <label for="%s">%s <br /><span style="font-size: small">%s</span></label>
        </div>
         <div class="input_col">
            <input id="%s" name="%s" type="text" value="%s" class="%s" style="%s"/><br />
            <span class="error_col">%s</span>
         </div>
         <div class="help_col">
            %s&nbsp;
         </div>
     </div>
     <br clear="left" />
     ';

    public function render($content)
    {
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $label   = htmlentities($element->getLabel());
        $sub_label   = htmlentities($element->getAttrib('sub_label'));
        $id      = htmlentities($element->getId());
        $value   = htmlentities($element->getValue());
        $style   = htmlentities($element->getAttrib('style'));
        $help   = htmlentities($element->getAttrib('help'));

        $class = htmlentities($element->getAttrib('class'));
        $error = "";
        $errors = $element->getErrors();
        if($errors){
            $error = 'Please enter a value';
            $class = 'error';
        }

        $markup  = sprintf($this->_format, $name, $label,$sub_label, $id, $name, $value,$class, $style,$error,$help);
        return $markup;
    }
}

/**
 * Created by JetBrains PhpStorm.
 * User: Kevin Saunders
 * Date: 18/05/12
 */
class Decorators_Radio extends Zend_Form_Decorator_Abstract
{
    protected $_format = '
    <div class="element">
        <div class="label_col">
            <label for="%s">%s <br /><span style="font-size: small">%s</span></label>
        </div>
         <div class="input_col">
            %s
            <span class="error_col">%s</span>
         </div>
         <div class="help_col">
            %s&nbsp;
         </div>
     </div>
     <br clear="left" />
     ';

    public function render($content)
    {
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $label   = htmlentities($element->getLabel());
        $sub_label   = htmlentities($element->getAttrib('sub_label'));
        $id      = htmlentities($element->getId());
        $radio_buttons   = $element->getMultiOptions();
        $style   = htmlentities($element->getAttrib('style'));
        $help   = htmlentities($element->getAttrib('help'));

        $class = htmlentities($element->getAttrib('class'));
        $error = "";
        $errors = $element->getErrors();
        if($errors){
            $error = 'Please select an option';
            $class = 'error';
        }

        $check = '<input id="%s" name="%s" type="radio" value="%s" class="%s" %s />&nbsp;%s<br />';
        $radio = '';
        $counter = 1;
        foreach($radio_buttons as $field => $value){
            $checked = '';
            if($element->getAttrib('default_value') == $field){
                $checked = 'checked= "checked"';
            }
            $radio .= sprintf($check, $name.'_'.$counter++,$name, $field, $class,$checked,$value);
        }

        $markup  = sprintf($this->_format, $name, $label,$sub_label, $radio,$error,$help);
        return $markup;
    }
}

class Decorators_Files extends Zend_Form_Decorator_Abstract
{
    protected $_format = '
    <div class="element">
        <div class="label_col">
            <label for="%s">%s</label>
        </div>
         <div class="input_col">
            <input id="%s" name="%s" type="file" value="%s" class="%s" style="%s"/><br />
            <span class="error_col">%s</span>
         </div>
     </div>
     <br clear="left" />
     ';

    public function render($content)
    {
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $label   = htmlentities($element->getLabel());
        $id      = htmlentities($element->getId());
        $value   = htmlentities($element->getValue());
        $style   = htmlentities($element->getAttrib('style'));

        $class = htmlentities($element->getAttrib('class'));
        $error = "";
        $errors = $element->getErrors();
        if($errors){
            $error = 'Please enter a value';
            $class = 'error';
        }

        $markup  = sprintf($this->_format, $name, $label, $id, $name, $value,$class, $style,$error);
        return $markup;
    }
}

class Decorators_Password extends Zend_Form_Decorator_Abstract implements Zend_Form_Decorator_Marker_File_Interface
{
    protected $_format = '
    <div class="element">
        <div class="label_col">
            <label for="%s">%s</label>
        </div>
         <div class="input_col">
            <input id="%s" name="%s" type="password" value="%s" class="%s" style="%s"/><br />
            <span class="error_col">%s</span>
         </div>
     </div>
     <br clear="left" />
     ';

    public function render($content)
    {
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $label   = htmlentities($element->getLabel());
        $id      = htmlentities($element->getId());
        $value   = htmlentities($element->getValue());
        $style   = htmlentities($element->getAttrib('style'));

        $class = htmlentities($element->getAttrib('class'));
        $error = "";
        $errors = $element->getErrors();
        if($errors){
            $error = 'Please enter a value';
            $class = 'error';
        }

        $markup  = sprintf($this->_format, $name, $label, $id, $name, $value,$class, $style,$error);
        return $markup;
    }
}

class Decorators_Hidden extends Zend_Form_Decorator_Abstract
{
    protected $_format = '<input id="%s" name="%s" type="hidden" value="%s"/>';

    public function render($content)
    {
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $id      = htmlentities($element->getId());
        $value   = htmlentities($element->getValue());
        $markup  = sprintf($this->_format, $id, $name, $value);
        return $markup;
    }
}

class Decorators_Text extends Zend_Form_Decorator_Abstract
{
    protected $_format = '
    <div class="element">
        <div class="input_2cols">
            <label for="%s">%s</label>&nbsp;<span class="error_text">%s</span>
        </div>
         <div class="input_2cols">
            <textarea name="%s" id="%s" rows="%s" cols="%s" class="%s">%s</textarea>
         </div>
    </div>
         ';

    public function render($content)
    {
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $label   = htmlentities($element->getLabel());
        $id      = htmlentities($element->getId());
        $rows   = htmlentities($element->getAttrib('rows'));
        $cols   = htmlentities($element->getAttrib('cols'));
        $value   = htmlentities($element->getValue());
        $class = htmlentities($element->getAttrib('class'));
        $error = "";
        $errors = $element->getErrors();
        if($errors){
            $error = htmlentities($element->getAttrib('error_message')) ?
                'Please enter a value' : htmlentities($element->getAttrib('error_message'));
            $class .= ' error';
        }

        $markup  = sprintf($this->_format, $name,$label,$error,$name, $id, $rows,$cols,$class, $value);
        return $markup;
    }
}

class Decorators_Submit extends Zend_Form_Decorator_Abstract
{
    protected $_format = '
         <div class="input_2cols">
            <input type="submit" name="%s" id="%s" value="%s">
         </div>';

    public function render($content)
    {
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $id      = htmlentities($element->getId());
        $value   = htmlentities($element->getValue()) ? htmlentities($element->getValue()) : 'Submit' ;

        $markup  = sprintf($this->_format, $name,$id, $value);
        return $markup;
    }
}

class Decorators_Captcha extends Zend_Form_Decorator_Abstract
{
    protected $_format = '
         <div class="input_2cols">
            <label for="%s" class="required">%s</label>
         </div>
         <div class="input_2cols">
            <img width="%s" height="%s" alt="" src="%s" />
<input type="hidden" name="captcha[id]" value="6500956bc4056e5b982f366ef66f5bac" id="captcha-id">
<input type="text" name="captcha[input]" id="captcha-input" value="">
         </div>';

    public function render($content)
    {
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $label   = htmlentities($element->getLabel());
        $id      = htmlentities($element->getId());
        $image   = htmlentities($element->getAttrib('src'));
        $height   = htmlentities($element->getAttrib('height'));
        $width   = htmlentities($element->getAttrib('width'));
        $value   = htmlentities($element->getValue());

        //$markup  = sprintf($this->_format, $name,$label,$name, $id, $rows,$cols, $value);
        return '';// $markup;
    }
}

