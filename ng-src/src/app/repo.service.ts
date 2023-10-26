import {Injectable, OnInit} from '@angular/core';
import {ApiService} from "./api.service";
import {HelperService} from "./helper.service";

@Injectable({
  providedIn: 'root'
})
export class RepoService {

  constructor(
    private api: ApiService,
    private helper: HelperService,
  ) {

  }

  requestDeploy(options: {
    projectId: any,
    serverId?: any,
    type: any,
    revision?: any,
  }) {
    return this.api.post('add-deploy-request', {
      project_id: options.projectId,
      server_id: options.serverId,
      type: options.type,
      revision: options.revision,
    });
  }

}
