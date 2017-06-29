<div class="grav-blocks-usage">
    <h2>Blocks currently in use.</h2>
    <p>
        This page shows the currently used blocks with links to where they are being used.
    </p>
    <br />
    <div class="grav-blocks-row">
        <div class="grav-blocks-column">
            <h3>Block Name</h3>
        </div>
        <div class="grav-blocks-column">
            <h3>Page(s) Block is Found</h3>
        </div>
    </div>
    <?php echo GRAV_BLOCKS::get_blocks_usage(); ?>
</div>
