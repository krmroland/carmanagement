import React from 'react';

import Card from '@material-ui/core/Card';
import CardContent from '@material-ui/core/CardContent';
import Typography from '@material-ui/core/Typography';
import PeopleOutlined from '@material-ui/icons/DeleteOutlined';

export default () => {
  return (
    <Card className="flex w-full rounded-none" variant="outlined" elevation={0}>
      <CardContent>
        <Typography variant="button">Mbasa And Sons</Typography>
        <div className="flex items-center">
          <PeopleOutlined style={{ fontSize: 40 }} className="text-gray-600" />
          <div className="ml-1">
            <Typography variant="subtitle2">Dues</Typography>
            <Typography variant="h6" className="font-extrabold" color="primary">
              $ 100000
            </Typography>
          </div>
        </div>
      </CardContent>
    </Card>
  );
};
