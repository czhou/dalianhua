//
//  Question.m
//  dalianhua
//
//  Created by Jack on 7/10/13.
//  Copyright (c) 2013 Salmonapps.com. All rights reserved.
//

#import "Question.h"
#import "AFNetworking.h"

@implementation Question

- (id)initWithJSON:(NSDictionary *)json {
    
    self = [super init];
    if (self) {
        self.question_id = [json objectForKey:@"question_id"];
        self.question = [json objectForKey:@"question"];
        self.answers = [json objectForKey:@"answers"];
        self.audio_url = [json objectForKey:@"audio"];
        return self;
    }
    
    return nil;
}

+ (void)next:(void (^)(Question *user, NSError *error))block {
    
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    [manager POST:[NSString stringWithFormat:@"%@%@", API_URL, API_FUNC_QUESTION] parameters:nil success:^(AFHTTPRequestOperation *operation, id responseObject) {
        NSLog(@"JSON: %@", responseObject);
        Question *next = [[Question alloc] initWithJSON:responseObject];
        block(next, nil);
        
    } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
        NSLog(@"Error: %@", error);
        block(nil, error);
    }];
    
}

@end
