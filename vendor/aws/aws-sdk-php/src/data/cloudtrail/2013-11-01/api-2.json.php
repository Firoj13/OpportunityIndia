<?php
// This file was auto-generated from sdk-root/src/data/cloudtrail/2013-11-01/api-2.json
return [ 'version' => '2.0', 'metadata' => [ 'apiVersion' => '2013-11-01', 'endpointPrefix' => 'cloudtrail', 'jsonVersion' => '1.1', 'protocol' => 'json', 'serviceAbbreviation' => 'CloudTrail', 'serviceFullName' => 'AWS CloudTrail', 'serviceId' => 'CloudTrail', 'signatureVersion' => 'v4', 'targetPrefix' => 'com.amazonaws.cloudtrail.v20131101.CloudTrail_20131101', 'uid' => 'cloudtrail-2013-11-01', ], 'operations' => [ 'AddTags' => [ 'name' => 'AddTags', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'AddTagsRequest', ], 'output' => [ 'shape' => 'AddTagsResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'CloudTrailARNInvalidException', ], [ 'shape' => 'ResourceTypeNotSupportedException', ], [ 'shape' => 'TagsLimitExceededException', ], [ 'shape' => 'InvalidTrailNameException', ], [ 'shape' => 'InvalidTagParameterException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], [ 'shape' => 'NotOrganizationMasterAccountException', ], ], 'idempotent' => true, ], 'CreateTrail' => [ 'name' => 'CreateTrail', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'CreateTrailRequest', ], 'output' => [ 'shape' => 'CreateTrailResponse', ], 'errors' => [ [ 'shape' => 'MaximumNumberOfTrailsExceededException', ], [ 'shape' => 'TrailAlreadyExistsException', ], [ 'shape' => 'S3BucketDoesNotExistException', ], [ 'shape' => 'InsufficientS3BucketPolicyException', ], [ 'shape' => 'InsufficientSnsTopicPolicyException', ], [ 'shape' => 'InsufficientEncryptionPolicyException', ], [ 'shape' => 'InvalidS3BucketNameException', ], [ 'shape' => 'InvalidS3PrefixException', ], [ 'shape' => 'InvalidSnsTopicNameException', ], [ 'shape' => 'InvalidKmsKeyIdException', ], [ 'shape' => 'InvalidTrailNameException', ], [ 'shape' => 'TrailNotProvidedException', ], [ 'shape' => 'InvalidParameterCombinationException', ], [ 'shape' => 'KmsKeyNotFoundException', ], [ 'shape' => 'KmsKeyDisabledException', ], [ 'shape' => 'KmsException', ], [ 'shape' => 'InvalidCloudWatchLogsLogGroupArnException', ], [ 'shape' => 'InvalidCloudWatchLogsRoleArnException', ], [ 'shape' => 'CloudWatchLogsDeliveryUnavailableException', ], [ 'shape' => 'InvalidTagParameterException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], [ 'shape' => 'CloudTrailAccessNotEnabledException', ], [ 'shape' => 'InsufficientDependencyServiceAccessPermissionException', ], [ 'shape' => 'NotOrganizationMasterAccountException', ], [ 'shape' => 'OrganizationsNotInUseException', ], [ 'shape' => 'OrganizationNotInAllFeaturesModeException', ], [ 'shape' => 'CloudTrailInvalidClientTokenIdException', ], ], 'idempotent' => true, ], 'DeleteTrail' => [ 'name' => 'DeleteTrail', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DeleteTrailRequest', ], 'output' => [ 'shape' => 'DeleteTrailResponse', ], 'errors' => [ [ 'shape' => 'TrailNotFoundException', ], [ 'shape' => 'InvalidTrailNameException', ], [ 'shape' => 'InvalidHomeRegionException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], [ 'shape' => 'NotOrganizationMasterAccountException', ], [ 'shape' => 'InsufficientDependencyServiceAccessPermissionException', ], [ 'shape' => 'ConflictException', ], ], 'idempotent' => true, ], 'DescribeTrails' => [ 'name' => 'DescribeTrails', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeTrailsRequest', ], 'output' => [ 'shape' => 'DescribeTrailsResponse', ], 'errors' => [ [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], [ 'shape' => 'InvalidTrailNameException', ], ], 'idempotent' => true, ], 'GetEventSelectors' => [ 'name' => 'GetEventSelectors', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'GetEventSelectorsRequest', ], 'output' => [ 'shape' => 'GetEventSelectorsResponse', ], 'errors' => [ [ 'shape' => 'TrailNotFoundException', ], [ 'shape' => 'InvalidTrailNameException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], ], 'idempotent' => true, ], 'GetInsightSelectors' => [ 'name' => 'GetInsightSelectors', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'GetInsightSelectorsRequest', ], 'output' => [ 'shape' => 'GetInsightSelectorsResponse', ], 'errors' => [ [ 'shape' => 'TrailNotFoundException', ], [ 'shape' => 'InvalidTrailNameException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], [ 'shape' => 'InsightNotEnabledException', ], ], 'idempotent' => true, ], 'GetTrail' => [ 'name' => 'GetTrail', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'GetTrailRequest', ], 'output' => [ 'shape' => 'GetTrailResponse', ], 'errors' => [ [ 'shape' => 'TrailNotFoundException', ], [ 'shape' => 'InvalidTrailNameException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], ], 'idempotent' => true, ], 'GetTrailStatus' => [ 'name' => 'GetTrailStatus', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'GetTrailStatusRequest', ], 'output' => [ 'shape' => 'GetTrailStatusResponse', ], 'errors' => [ [ 'shape' => 'TrailNotFoundException', ], [ 'shape' => 'InvalidTrailNameException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], ], 'idempotent' => true, ], 'ListPublicKeys' => [ 'name' => 'ListPublicKeys', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'ListPublicKeysRequest', ], 'output' => [ 'shape' => 'ListPublicKeysResponse', ], 'errors' => [ [ 'shape' => 'InvalidTimeRangeException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], [ 'shape' => 'InvalidTokenException', ], ], 'idempotent' => true, ], 'ListTags' => [ 'name' => 'ListTags', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'ListTagsRequest', ], 'output' => [ 'shape' => 'ListTagsResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'CloudTrailARNInvalidException', ], [ 'shape' => 'ResourceTypeNotSupportedException', ], [ 'shape' => 'InvalidTrailNameException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], [ 'shape' => 'InvalidTokenException', ], ], 'idempotent' => true, ], 'ListTrails' => [ 'name' => 'ListTrails', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'ListTrailsRequest', ], 'output' => [ 'shape' => 'ListTrailsResponse', ], 'errors' => [ [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], ], 'idempotent' => true, ], 'LookupEvents' => [ 'name' => 'LookupEvents', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'LookupEventsRequest', ], 'output' => [ 'shape' => 'LookupEventsResponse', ], 'errors' => [ [ 'shape' => 'InvalidLookupAttributesException', ], [ 'shape' => 'InvalidTimeRangeException', ], [ 'shape' => 'InvalidMaxResultsException', ], [ 'shape' => 'InvalidNextTokenException', ], [ 'shape' => 'InvalidEventCategoryException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], ], 'idempotent' => true, ], 'PutEventSelectors' => [ 'name' => 'PutEventSelectors', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'PutEventSelectorsRequest', ], 'output' => [ 'shape' => 'PutEventSelectorsResponse', ], 'errors' => [ [ 'shape' => 'TrailNotFoundException', ], [ 'shape' => 'InvalidTrailNameException', ], [ 'shape' => 'InvalidHomeRegionException', ], [ 'shape' => 'InvalidEventSelectorsException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], [ 'shape' => 'NotOrganizationMasterAccountException', ], [ 'shape' => 'InsufficientDependencyServiceAccessPermissionException', ], ], 'idempotent' => true, ], 'PutInsightSelectors' => [ 'name' => 'PutInsightSelectors', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'PutInsightSelectorsRequest', ], 'output' => [ 'shape' => 'PutInsightSelectorsResponse', ], 'errors' => [ [ 'shape' => 'TrailNotFoundException', ], [ 'shape' => 'InvalidTrailNameException', ], [ 'shape' => 'InvalidHomeRegionException', ], [ 'shape' => 'InvalidInsightSelectorsException', ], [ 'shape' => 'InsufficientS3BucketPolicyException', ], [ 'shape' => 'InsufficientEncryptionPolicyException', ], [ 'shape' => 'S3BucketDoesNotExistException', ], [ 'shape' => 'KmsException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], [ 'shape' => 'NotOrganizationMasterAccountException', ], ], 'idempotent' => true, ], 'RemoveTags' => [ 'name' => 'RemoveTags', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'RemoveTagsRequest', ], 'output' => [ 'shape' => 'RemoveTagsResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'CloudTrailARNInvalidException', ], [ 'shape' => 'ResourceTypeNotSupportedException', ], [ 'shape' => 'InvalidTrailNameException', ], [ 'shape' => 'InvalidTagParameterException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], [ 'shape' => 'NotOrganizationMasterAccountException', ], ], 'idempotent' => true, ], 'StartLogging' => [ 'name' => 'StartLogging', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'StartLoggingRequest', ], 'output' => [ 'shape' => 'StartLoggingResponse', ], 'errors' => [ [ 'shape' => 'TrailNotFoundException', ], [ 'shape' => 'InvalidTrailNameException', ], [ 'shape' => 'InvalidHomeRegionException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], [ 'shape' => 'NotOrganizationMasterAccountException', ], [ 'shape' => 'InsufficientDependencyServiceAccessPermissionException', ], ], 'idempotent' => true, ], 'StopLogging' => [ 'name' => 'StopLogging', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'StopLoggingRequest', ], 'output' => [ 'shape' => 'StopLoggingResponse', ], 'errors' => [ [ 'shape' => 'TrailNotFoundException', ], [ 'shape' => 'InvalidTrailNameException', ], [ 'shape' => 'InvalidHomeRegionException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], [ 'shape' => 'NotOrganizationMasterAccountException', ], [ 'shape' => 'InsufficientDependencyServiceAccessPermissionException', ], ], 'idempotent' => true, ], 'UpdateTrail' => [ 'name' => 'UpdateTrail', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'UpdateTrailRequest', ], 'output' => [ 'shape' => 'UpdateTrailResponse', ], 'errors' => [ [ 'shape' => 'S3BucketDoesNotExistException', ], [ 'shape' => 'InsufficientS3BucketPolicyException', ], [ 'shape' => 'InsufficientSnsTopicPolicyException', ], [ 'shape' => 'InsufficientEncryptionPolicyException', ], [ 'shape' => 'TrailNotFoundException', ], [ 'shape' => 'InvalidS3BucketNameException', ], [ 'shape' => 'InvalidS3PrefixException', ], [ 'shape' => 'InvalidSnsTopicNameException', ], [ 'shape' => 'InvalidKmsKeyIdException', ], [ 'shape' => 'InvalidTrailNameException', ], [ 'shape' => 'TrailNotProvidedException', ], [ 'shape' => 'InvalidEventSelectorsException', ], [ 'shape' => 'InvalidParameterCombinationException', ], [ 'shape' => 'InvalidHomeRegionException', ], [ 'shape' => 'KmsKeyNotFoundException', ], [ 'shape' => 'KmsKeyDisabledException', ], [ 'shape' => 'KmsException', ], [ 'shape' => 'InvalidCloudWatchLogsLogGroupArnException', ], [ 'shape' => 'InvalidCloudWatchLogsRoleArnException', ], [ 'shape' => 'CloudWatchLogsDeliveryUnavailableException', ], [ 'shape' => 'UnsupportedOperationException', ], [ 'shape' => 'OperationNotPermittedException', ], [ 'shape' => 'CloudTrailAccessNotEnabledException', ], [ 'shape' => 'InsufficientDependencyServiceAccessPermissionException', ], [ 'shape' => 'OrganizationsNotInUseException', ], [ 'shape' => 'NotOrganizationMasterAccountException', ], [ 'shape' => 'OrganizationNotInAllFeaturesModeException', ], [ 'shape' => 'CloudTrailInvalidClientTokenIdException', ], ], 'idempotent' => true, ], ], 'shapes' => [ 'AddTagsRequest' => [ 'type' => 'structure', 'required' => [ 'ResourceId', ], 'members' => [ 'ResourceId' => [ 'shape' => 'String', ], 'TagsList' => [ 'shape' => 'TagsList', ], ], ], 'AddTagsResponse' => [ 'type' => 'structure', 'members' => [], ], 'AdvancedEventSelector' => [ 'type' => 'structure', 'required' => [ 'FieldSelectors', ], 'members' => [ 'Name' => [ 'shape' => 'SelectorName', ], 'FieldSelectors' => [ 'shape' => 'AdvancedFieldSelectors', ], ], ], 'AdvancedEventSelectors' => [ 'type' => 'list', 'member' => [ 'shape' => 'AdvancedEventSelector', ], ], 'AdvancedFieldSelector' => [ 'type' => 'structure', 'required' => [ 'Field', ], 'members' => [ 'Field' => [ 'shape' => 'SelectorField', ], 'Equals' => [ 'shape' => 'Operator', ], 'StartsWith' => [ 'shape' => 'Operator', ], 'EndsWith' => [ 'shape' => 'Operator', ], 'NotEquals' => [ 'shape' => 'Operator', ], 'NotStartsWith' => [ 'shape' => 'Operator', ], 'NotEndsWith' => [ 'shape' => 'Operator', ], ], ], 'AdvancedFieldSelectors' => [ 'type' => 'list', 'member' => [ 'shape' => 'AdvancedFieldSelector', ], 'min' => 1, ], 'Boolean' => [ 'type' => 'boolean', ], 'ByteBuffer' => [ 'type' => 'blob', ], 'CloudTrailARNInvalidException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'CloudTrailAccessNotEnabledException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'CloudTrailInvalidClientTokenIdException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'CloudWatchLogsDeliveryUnavailableException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'ConflictException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'CreateTrailRequest' => [ 'type' => 'structure', 'required' => [ 'Name', 'S3BucketName', ], 'members' => [ 'Name' => [ 'shape' => 'String', ], 'S3BucketName' => [ 'shape' => 'String', ], 'S3KeyPrefix' => [ 'shape' => 'String', ], 'SnsTopicName' => [ 'shape' => 'String', ], 'IncludeGlobalServiceEvents' => [ 'shape' => 'Boolean', ], 'IsMultiRegionTrail' => [ 'shape' => 'Boolean', ], 'EnableLogFileValidation' => [ 'shape' => 'Boolean', ], 'CloudWatchLogsLogGroupArn' => [ 'shape' => 'String', ], 'CloudWatchLogsRoleArn' => [ 'shape' => 'String', ], 'KmsKeyId' => [ 'shape' => 'String', ], 'IsOrganizationTrail' => [ 'shape' => 'Boolean', ], 'TagsList' => [ 'shape' => 'TagsList', ], ], ], 'CreateTrailResponse' => [ 'type' => 'structure', 'members' => [ 'Name' => [ 'shape' => 'String', ], 'S3BucketName' => [ 'shape' => 'String', ], 'S3KeyPrefix' => [ 'shape' => 'String', ], 'SnsTopicName' => [ 'shape' => 'String', 'deprecated' => true, ], 'SnsTopicARN' => [ 'shape' => 'String', ], 'IncludeGlobalServiceEvents' => [ 'shape' => 'Boolean', ], 'IsMultiRegionTrail' => [ 'shape' => 'Boolean', ], 'TrailARN' => [ 'shape' => 'String', ], 'LogFileValidationEnabled' => [ 'shape' => 'Boolean', ], 'CloudWatchLogsLogGroupArn' => [ 'shape' => 'String', ], 'CloudWatchLogsRoleArn' => [ 'shape' => 'String', ], 'KmsKeyId' => [ 'shape' => 'String', ], 'IsOrganizationTrail' => [ 'shape' => 'Boolean', ], ], ], 'DataResource' => [ 'type' => 'structure', 'members' => [ 'Type' => [ 'shape' => 'String', ], 'Values' => [ 'shape' => 'DataResourceValues', ], ], ], 'DataResourceValues' => [ 'type' => 'list', 'member' => [ 'shape' => 'String', ], ], 'DataResources' => [ 'type' => 'list', 'member' => [ 'shape' => 'DataResource', ], ], 'Date' => [ 'type' => 'timestamp', ], 'DeleteTrailRequest' => [ 'type' => 'structure', 'required' => [ 'Name', ], 'members' => [ 'Name' => [ 'shape' => 'String', ], ], ], 'DeleteTrailResponse' => [ 'type' => 'structure', 'members' => [], ], 'DescribeTrailsRequest' => [ 'type' => 'structure', 'members' => [ 'trailNameList' => [ 'shape' => 'TrailNameList', ], 'includeShadowTrails' => [ 'shape' => 'Boolean', ], ], ], 'DescribeTrailsResponse' => [ 'type' => 'structure', 'members' => [ 'trailList' => [ 'shape' => 'TrailList', ], ], ], 'Event' => [ 'type' => 'structure', 'members' => [ 'EventId' => [ 'shape' => 'String', ], 'EventName' => [ 'shape' => 'String', ], 'ReadOnly' => [ 'shape' => 'String', ], 'AccessKeyId' => [ 'shape' => 'String', ], 'EventTime' => [ 'shape' => 'Date', ], 'EventSource' => [ 'shape' => 'String', ], 'Username' => [ 'shape' => 'String', ], 'Resources' => [ 'shape' => 'ResourceList', ], 'CloudTrailEvent' => [ 'shape' => 'String', ], ], ], 'EventCategory' => [ 'type' => 'string', 'enum' => [ 'insight', ], ], 'EventSelector' => [ 'type' => 'structure', 'members' => [ 'ReadWriteType' => [ 'shape' => 'ReadWriteType', ], 'IncludeManagementEvents' => [ 'shape' => 'Boolean', ], 'DataResources' => [ 'shape' => 'DataResources', ], 'ExcludeManagementEventSources' => [ 'shape' => 'ExcludeManagementEventSources', ], ], ], 'EventSelectors' => [ 'type' => 'list', 'member' => [ 'shape' => 'EventSelector', ], ], 'EventsList' => [ 'type' => 'list', 'member' => [ 'shape' => 'Event', ], ], 'ExcludeManagementEventSources' => [ 'type' => 'list', 'member' => [ 'shape' => 'String', ], ], 'GetEventSelectorsRequest' => [ 'type' => 'structure', 'required' => [ 'TrailName', ], 'members' => [ 'TrailName' => [ 'shape' => 'String', ], ], ], 'GetEventSelectorsResponse' => [ 'type' => 'structure', 'members' => [ 'TrailARN' => [ 'shape' => 'String', ], 'EventSelectors' => [ 'shape' => 'EventSelectors', ], 'AdvancedEventSelectors' => [ 'shape' => 'AdvancedEventSelectors', ], ], ], 'GetInsightSelectorsRequest' => [ 'type' => 'structure', 'required' => [ 'TrailName', ], 'members' => [ 'TrailName' => [ 'shape' => 'String', ], ], ], 'GetInsightSelectorsResponse' => [ 'type' => 'structure', 'members' => [ 'TrailARN' => [ 'shape' => 'String', ], 'InsightSelectors' => [ 'shape' => 'InsightSelectors', ], ], ], 'GetTrailRequest' => [ 'type' => 'structure', 'required' => [ 'Name', ], 'members' => [ 'Name' => [ 'shape' => 'String', ], ], ], 'GetTrailResponse' => [ 'type' => 'structure', 'members' => [ 'Trail' => [ 'shape' => 'Trail', ], ], ], 'GetTrailStatusRequest' => [ 'type' => 'structure', 'required' => [ 'Name', ], 'members' => [ 'Name' => [ 'shape' => 'String', ], ], ], 'GetTrailStatusResponse' => [ 'type' => 'structure', 'members' => [ 'IsLogging' => [ 'shape' => 'Boolean', ], 'LatestDeliveryError' => [ 'shape' => 'String', ], 'LatestNotificationError' => [ 'shape' => 'String', ], 'LatestDeliveryTime' => [ 'shape' => 'Date', ], 'LatestNotificationTime' => [ 'shape' => 'Date', ], 'StartLoggingTime' => [ 'shape' => 'Date', ], 'StopLoggingTime' => [ 'shape' => 'Date', ], 'LatestCloudWatchLogsDeliveryError' => [ 'shape' => 'String', ], 'LatestCloudWatchLogsDeliveryTime' => [ 'shape' => 'Date', ], 'LatestDigestDeliveryTime' => [ 'shape' => 'Date', ], 'LatestDigestDeliveryError' => [ 'shape' => 'String', ], 'LatestDeliveryAttemptTime' => [ 'shape' => 'String', ], 'LatestNotificationAttemptTime' => [ 'shape' => 'String', ], 'LatestNotificationAttemptSucceeded' => [ 'shape' => 'String', ], 'LatestDeliveryAttemptSucceeded' => [ 'shape' => 'String', ], 'TimeLoggingStarted' => [ 'shape' => 'String', ], 'TimeLoggingStopped' => [ 'shape' => 'String', ], ], ], 'InsightNotEnabledException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InsightSelector' => [ 'type' => 'structure', 'members' => [ 'InsightType' => [ 'shape' => 'InsightType', ], ], ], 'InsightSelectors' => [ 'type' => 'list', 'member' => [ 'shape' => 'InsightSelector', ], ], 'InsightType' => [ 'type' => 'string', 'enum' => [ 'ApiCallRateInsight', 'ApiErrorRateInsight', ], ], 'InsufficientDependencyServiceAccessPermissionException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InsufficientEncryptionPolicyException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InsufficientS3BucketPolicyException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InsufficientSnsTopicPolicyException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidCloudWatchLogsLogGroupArnException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidCloudWatchLogsRoleArnException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidEventCategoryException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidEventSelectorsException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidHomeRegionException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidInsightSelectorsException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidKmsKeyIdException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidLookupAttributesException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidMaxResultsException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidNextTokenException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidParameterCombinationException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidS3BucketNameException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidS3PrefixException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidSnsTopicNameException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidTagParameterException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidTimeRangeException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidTokenException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'InvalidTrailNameException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'KmsException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'KmsKeyDisabledException' => [ 'type' => 'structure', 'members' => [], 'deprecated' => true, 'exception' => true, ], 'KmsKeyNotFoundException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'ListPublicKeysRequest' => [ 'type' => 'structure', 'members' => [ 'StartTime' => [ 'shape' => 'Date', ], 'EndTime' => [ 'shape' => 'Date', ], 'NextToken' => [ 'shape' => 'String', ], ], ], 'ListPublicKeysResponse' => [ 'type' => 'structure', 'members' => [ 'PublicKeyList' => [ 'shape' => 'PublicKeyList', ], 'NextToken' => [ 'shape' => 'String', ], ], ], 'ListTagsRequest' => [ 'type' => 'structure', 'required' => [ 'ResourceIdList', ], 'members' => [ 'ResourceIdList' => [ 'shape' => 'ResourceIdList', ], 'NextToken' => [ 'shape' => 'String', ], ], ], 'ListTagsResponse' => [ 'type' => 'structure', 'members' => [ 'ResourceTagList' => [ 'shape' => 'ResourceTagList', ], 'NextToken' => [ 'shape' => 'String', ], ], ], 'ListTrailsRequest' => [ 'type' => 'structure', 'members' => [ 'NextToken' => [ 'shape' => 'String', ], ], ], 'ListTrailsResponse' => [ 'type' => 'structure', 'members' => [ 'Trails' => [ 'shape' => 'Trails', ], 'NextToken' => [ 'shape' => 'String', ], ], ], 'LookupAttribute' => [ 'type' => 'structure', 'required' => [ 'AttributeKey', 'AttributeValue', ], 'members' => [ 'AttributeKey' => [ 'shape' => 'LookupAttributeKey', ], 'AttributeValue' => [ 'shape' => 'String', ], ], ], 'LookupAttributeKey' => [ 'type' => 'string', 'enum' => [ 'EventId', 'EventName', 'ReadOnly', 'Username', 'ResourceType', 'ResourceName', 'EventSource', 'AccessKeyId', ], ], 'LookupAttributesList' => [ 'type' => 'list', 'member' => [ 'shape' => 'LookupAttribute', ], ], 'LookupEventsRequest' => [ 'type' => 'structure', 'members' => [ 'LookupAttributes' => [ 'shape' => 'LookupAttributesList', ], 'StartTime' => [ 'shape' => 'Date', ], 'EndTime' => [ 'shape' => 'Date', ], 'EventCategory' => [ 'shape' => 'EventCategory', ], 'MaxResults' => [ 'shape' => 'MaxResults', ], 'NextToken' => [ 'shape' => 'NextToken', ], ], ], 'LookupEventsResponse' => [ 'type' => 'structure', 'members' => [ 'Events' => [ 'shape' => 'EventsList', ], 'NextToken' => [ 'shape' => 'NextToken', ], ], ], 'MaxResults' => [ 'type' => 'integer', 'max' => 50, 'min' => 1, ], 'MaximumNumberOfTrailsExceededException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'NextToken' => [ 'type' => 'string', ], 'NotOrganizationMasterAccountException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'OperationNotPermittedException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'Operator' => [ 'type' => 'list', 'member' => [ 'shape' => 'OperatorValue', ], 'min' => 1, ], 'OperatorValue' => [ 'type' => 'string', 'max' => 2048, 'min' => 1, 'pattern' => '.+', ], 'OrganizationNotInAllFeaturesModeException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'OrganizationsNotInUseException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'PublicKey' => [ 'type' => 'structure', 'members' => [ 'Value' => [ 'shape' => 'ByteBuffer', ], 'ValidityStartTime' => [ 'shape' => 'Date', ], 'ValidityEndTime' => [ 'shape' => 'Date', ], 'Fingerprint' => [ 'shape' => 'String', ], ], ], 'PublicKeyList' => [ 'type' => 'list', 'member' => [ 'shape' => 'PublicKey', ], ], 'PutEventSelectorsRequest' => [ 'type' => 'structure', 'required' => [ 'TrailName', ], 'members' => [ 'TrailName' => [ 'shape' => 'String', ], 'EventSelectors' => [ 'shape' => 'EventSelectors', ], 'AdvancedEventSelectors' => [ 'shape' => 'AdvancedEventSelectors', ], ], ], 'PutEventSelectorsResponse' => [ 'type' => 'structure', 'members' => [ 'TrailARN' => [ 'shape' => 'String', ], 'EventSelectors' => [ 'shape' => 'EventSelectors', ], 'AdvancedEventSelectors' => [ 'shape' => 'AdvancedEventSelectors', ], ], ], 'PutInsightSelectorsRequest' => [ 'type' => 'structure', 'required' => [ 'TrailName', 'InsightSelectors', ], 'members' => [ 'TrailName' => [ 'shape' => 'String', ], 'InsightSelectors' => [ 'shape' => 'InsightSelectors', ], ], ], 'PutInsightSelectorsResponse' => [ 'type' => 'structure', 'members' => [ 'TrailARN' => [ 'shape' => 'String', ], 'InsightSelectors' => [ 'shape' => 'InsightSelectors', ], ], ], 'ReadWriteType' => [ 'type' => 'string', 'enum' => [ 'ReadOnly', 'WriteOnly', 'All', ], ], 'RemoveTagsRequest' => [ 'type' => 'structure', 'required' => [ 'ResourceId', ], 'members' => [ 'ResourceId' => [ 'shape' => 'String', ], 'TagsList' => [ 'shape' => 'TagsList', ], ], ], 'RemoveTagsResponse' => [ 'type' => 'structure', 'members' => [], ], 'Resource' => [ 'type' => 'structure', 'members' => [ 'ResourceType' => [ 'shape' => 'String', ], 'ResourceName' => [ 'shape' => 'String', ], ], ], 'ResourceIdList' => [ 'type' => 'list', 'member' => [ 'shape' => 'String', ], ], 'ResourceList' => [ 'type' => 'list', 'member' => [ 'shape' => 'Resource', ], ], 'ResourceNotFoundException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'ResourceTag' => [ 'type' => 'structure', 'members' => [ 'ResourceId' => [ 'shape' => 'String', ], 'TagsList' => [ 'shape' => 'TagsList', ], ], ], 'ResourceTagList' => [ 'type' => 'list', 'member' => [ 'shape' => 'ResourceTag', ], ], 'ResourceTypeNotSupportedException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'S3BucketDoesNotExistException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'SelectorField' => [ 'type' => 'string', 'max' => 1000, 'min' => 1, 'pattern' => '[\\w|\\d|\\.|_]+', ], 'SelectorName' => [ 'type' => 'string', 'max' => 1000, 'min' => 0, 'pattern' => '.*', ], 'StartLoggingRequest' => [ 'type' => 'structure', 'required' => [ 'Name', ], 'members' => [ 'Name' => [ 'shape' => 'String', ], ], ], 'StartLoggingResponse' => [ 'type' => 'structure', 'members' => [], ], 'StopLoggingRequest' => [ 'type' => 'structure', 'required' => [ 'Name', ], 'members' => [ 'Name' => [ 'shape' => 'String', ], ], ], 'StopLoggingResponse' => [ 'type' => 'structure', 'members' => [], ], 'String' => [ 'type' => 'string', ], 'Tag' => [ 'type' => 'structure', 'required' => [ 'Key', ], 'members' => [ 'Key' => [ 'shape' => 'String', ], 'Value' => [ 'shape' => 'String', ], ], ], 'TagsLimitExceededException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'TagsList' => [ 'type' => 'list', 'member' => [ 'shape' => 'Tag', ], ], 'Trail' => [ 'type' => 'structure', 'members' => [ 'Name' => [ 'shape' => 'String', ], 'S3BucketName' => [ 'shape' => 'String', ], 'S3KeyPrefix' => [ 'shape' => 'String', ], 'SnsTopicName' => [ 'shape' => 'String', 'deprecated' => true, ], 'SnsTopicARN' => [ 'shape' => 'String', ], 'IncludeGlobalServiceEvents' => [ 'shape' => 'Boolean', ], 'IsMultiRegionTrail' => [ 'shape' => 'Boolean', ], 'HomeRegion' => [ 'shape' => 'String', ], 'TrailARN' => [ 'shape' => 'String', ], 'LogFileValidationEnabled' => [ 'shape' => 'Boolean', ], 'CloudWatchLogsLogGroupArn' => [ 'shape' => 'String', ], 'CloudWatchLogsRoleArn' => [ 'shape' => 'String', ], 'KmsKeyId' => [ 'shape' => 'String', ], 'HasCustomEventSelectors' => [ 'shape' => 'Boolean', ], 'HasInsightSelectors' => [ 'shape' => 'Boolean', ], 'IsOrganizationTrail' => [ 'shape' => 'Boolean', ], ], ], 'TrailAlreadyExistsException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'TrailInfo' => [ 'type' => 'structure', 'members' => [ 'TrailARN' => [ 'shape' => 'String', ], 'Name' => [ 'shape' => 'String', ], 'HomeRegion' => [ 'shape' => 'String', ], ], ], 'TrailList' => [ 'type' => 'list', 'member' => [ 'shape' => 'Trail', ], ], 'TrailNameList' => [ 'type' => 'list', 'member' => [ 'shape' => 'String', ], ], 'TrailNotFoundException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'TrailNotProvidedException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'Trails' => [ 'type' => 'list', 'member' => [ 'shape' => 'TrailInfo', ], ], 'UnsupportedOperationException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'UpdateTrailRequest' => [ 'type' => 'structure', 'required' => [ 'Name', ], 'members' => [ 'Name' => [ 'shape' => 'String', ], 'S3BucketName' => [ 'shape' => 'String', ], 'S3KeyPrefix' => [ 'shape' => 'String', ], 'SnsTopicName' => [ 'shape' => 'String', ], 'IncludeGlobalServiceEvents' => [ 'shape' => 'Boolean', ], 'IsMultiRegionTrail' => [ 'shape' => 'Boolean', ], 'EnableLogFileValidation' => [ 'shape' => 'Boolean', ], 'CloudWatchLogsLogGroupArn' => [ 'shape' => 'String', ], 'CloudWatchLogsRoleArn' => [ 'shape' => 'String', ], 'KmsKeyId' => [ 'shape' => 'String', ], 'IsOrganizationTrail' => [ 'shape' => 'Boolean', ], ], ], 'UpdateTrailResponse' => [ 'type' => 'structure', 'members' => [ 'Name' => [ 'shape' => 'String', ], 'S3BucketName' => [ 'shape' => 'String', ], 'S3KeyPrefix' => [ 'shape' => 'String', ], 'SnsTopicName' => [ 'shape' => 'String', 'deprecated' => true, ], 'SnsTopicARN' => [ 'shape' => 'String', ], 'IncludeGlobalServiceEvents' => [ 'shape' => 'Boolean', ], 'IsMultiRegionTrail' => [ 'shape' => 'Boolean', ], 'TrailARN' => [ 'shape' => 'String', ], 'LogFileValidationEnabled' => [ 'shape' => 'Boolean', ], 'CloudWatchLogsLogGroupArn' => [ 'shape' => 'String', ], 'CloudWatchLogsRoleArn' => [ 'shape' => 'String', ], 'KmsKeyId' => [ 'shape' => 'String', ], 'IsOrganizationTrail' => [ 'shape' => 'Boolean', ], ], ], ],];
