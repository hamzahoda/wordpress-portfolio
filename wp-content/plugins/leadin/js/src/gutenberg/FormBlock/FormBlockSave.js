import React, { Fragment } from 'react';
import { formsScript, formsScriptPayload } from '../../constants/leadinConfig';

export default function FormSaveBlock({ attributes }) {
  const { portalId, formId } = attributes;

  if (portalId && formId) {
    return (
      <Fragment>
        <script>
          {`
            hbsptReady({
              portalId: '${portalId}',
              formId: '${formId}',
              ${formsScriptPayload}
            });
          `}
        </script>
        <script
          charset="utf-8"
          type="text/javascript"
          src={formsScript}
          defer="true"
          onLoad="window.hbsptReady()"
        />
      </Fragment>
    );
  }
  return null;
}
