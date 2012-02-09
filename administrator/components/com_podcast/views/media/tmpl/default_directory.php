<?php defined('_JEXEC') or die; ?>

<ul>
<?php foreach ($this->files as $file) : ?>
    <li><?php echo $file ?></li>
<?php endforeach; ?>
<?php if (!count($this->files)) : ?>
    <p>No files</p>
<?php endif; ?>
</ul>