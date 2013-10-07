//
//  Question.h
//  dalianhua
//
//  Created by Jack on 7/10/13.
//  Copyright (c) 2013 Salmonapps.com. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface Question : NSObject

@property (nonatomic, strong) NSString *question_id;
@property (nonatomic, strong) NSString *question;
@property (nonatomic, strong) NSString *audio_url;
@property (nonatomic, strong) NSArray *answers;

- (id)initWithJSON:(NSDictionary *)json;
+ (void)next:(void (^)(Question *question, NSError *error))block;

@end
