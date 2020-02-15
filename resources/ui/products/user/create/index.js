import React from 'react';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogTitle from '@material-ui/core/DialogTitle';
import AddIcon from '@material-ui/icons/Add';
import { useAPIForm, Input } from '@/common/forms';

export default function FormDialog() {
  const [open, setOpen] = React.useState(true);

  const form = useAPIForm('POST');

  return (
    <div>
      <Button
        disableRipple
        onClick={() => setOpen(true)}
        variant="outlined"
        fullWidth
        color="primary"
      >
        <AddIcon />
        Add New Project
      </Button>

      <Dialog open={open} onClose={() => setOpen(false)} maxWidth="xs" disableBackdropClick>
        <DialogTitle id="form-dialog-title">Create a new Product</DialogTitle>
        <DialogContent>
          <Input form={form} label="Name" type="email" placeholder="The overall product's name" />

          <Input form={form} label="Type" placeholder="The overall product's name" />

          <Button
            onClick={() => {
              form.send('api/v1/products');
            }}
            color="primary"
            variant="contained"
            className="mt-2"
            disableElevation
            fullWidth
          >
            Save
          </Button>
        </DialogContent>
        <DialogActions>
          <Button onClick={() => setOpen(false)} color="primary">
            Cancel
          </Button>
        </DialogActions>
      </Dialog>
    </div>
  );
}
