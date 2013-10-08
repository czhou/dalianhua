//
//  ViewController.m
//  dalianhua
//
//  Created by Jack on 7/10/13.
//  Copyright (c) 2013 Salmonapps.com. All rights reserved.
//

#import "ViewController.h"
#import <AVFoundation/AVFoundation.h>
#import "Question.h"

@interface ViewController ()

@end

@implementation ViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
	
    
    [Question next:^(Question *question, NSError *error) {
        self.current = question;
        [self render];
    }];
    
}

- (void)render {
    //题面
    textView.text = self.current.question;
    
    NSInteger start_answer_y = 200;
    
    //答案
    [self.current.answers enumerateObjectsUsingBlock:^(id obj, NSUInteger idx, BOOL *stop) {
        
        NSString *title = [obj objectForKey:@"content"];
        NSData *archivedData = [NSKeyedArchiver archivedDataWithRootObject: skipButton];
        UIButton *ans = [NSKeyedUnarchiver unarchiveObjectWithData: archivedData];
        ans.frame = CGRectMake(skipButton.frame.origin.x, start_answer_y + idx*ans.frame.size.height, skipButton.frame.size.width, skipButton.frame.size.height);
        [ans setTitle:title forState:UIControlStateNormal];
        [ans addTarget:self action:@selector(tapAnswer:) forControlEvents:UIControlEventTouchUpInside];
        [self.view addSubview:ans];
    }];
    
}

- (void)tapAnswer:(id)sender {
    
}

- (IBAction)tapSkip:(id)sender {
    [Question next:^(Question *question, NSError *error) {
        self.current = question;
        [self render];
    }];
}

- (IBAction)tapPlay:(id)sender {
    
    if (!self.current.audio_url) {
        return;
    }
    AVPlayer *player = [AVPlayer playerWithURL:[NSURL  URLWithString:self.current.audio_url]];
    [player play];
    
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
